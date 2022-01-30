<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Services;

use BitcoinPHP\BitcoinECDSA\BitcoinECDSA;
use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Base58;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Key\PublicKey;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;
use BitWasp\Buffertools\Buffer;
use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\Crypto\Signature\Signer;
use Mdanter\Ecc\Crypto\Signature\SignHasher;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\PemPublicKeySerializer;
use Mdanter\Ecc\Serializer\Signature\DerSignatureSerializer;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Helpers\ValidationHelper;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnCrypt\Pki\JsonDSig\Domain\Libs\C14n;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\AddressEntity;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\TransactionEntity;
use ZnSandbox\Sandbox\BlockChain\Domain\Helper\BitcoinHelper;
use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Repositories\TransactionRepositoryInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Services\TransactionServiceInterface;
use GMP;
use ZnSandbox\Sandbox\BlockChain\Domain\Libs\BitcoinKey;

//https://tools.bitcoin.com/verify-message/
//https://www.verifybitcoinmessage.com/
//https://reinproject.org/bitcoin-signature-tool/

/**
 * @method TransactionRepositoryInterface getRepository()
 */
class TransactionService extends BaseCrudService implements TransactionServiceInterface
{

    private $privateKeyWif = 'Kwoii6A3caGLhVfms1c8KnxnqGVzaZjLJfguDvzJvBiTbzBCHKKB';

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return TransactionEntity::class;
    }

    protected function getPayload(TransactionEntity $transactionEntity): array
    {
        $data = [
            'from' => $transactionEntity->getFromAddress(),
            'to' => $transactionEntity->getToAddress(),
            'amount' => $transactionEntity->getAmount(),
            'createdAt' => $transactionEntity->getCreatedAt(),
//            'payload' => $transactionEntity->getPayload(),
        ];
        return $data;
    }

    protected function getDigest(TransactionEntity $transactionEntity): GMP
    {
        /*$data = [
            'fromAddress' => $transactionEntity->getFromAddress(),
            'toAddress' => $transactionEntity->getToAddress(),
            'amount' => $transactionEntity->getAmount(),
            'createdAt' => $transactionEntity->getCreatedAt(),
            'payload' => $transactionEntity->getPayload(),
        ];*/

        $data = $transactionEntity->getPayload();

        if (empty($data)) {
            throw new \Exception('Empty payload!');
        }
        //dd($data);

//        $adapter = EccFactory::getAdapter();
        $generator = EccFactory::getNistCurves()->generator384();
        $algorithm = 'sha256';

        $hasher = new SignHasher($algorithm);

        $c14n = new C14n([
//            'sort-string',
            'json-unescaped-unicode',
        ]);
        $canonicalJson = $c14n->encode($data);
        //dd($canonicalJson);
        $gmp = $hasher->makeHash($canonicalJson, $generator);
        return $gmp;
    }

    public function send(string $privateKey, string $toAddress, int $amount): TransactionEntity
    {
        BitcoinHelper::validateAddress($toAddress);

        $bitcoinKey = new BitcoinKey($this->privateKeyWif);
        $network = $bitcoinKey->getAddr();

        $addressEntity = new AddressEntity();
        $addressEntity->setAddress($network->getAddress());
        $addressEntity->setHash(Base58::decode($network->getAddress())->getHex());
        $addressEntity->setPublicKey($bitcoinKey->getPublic()->getPubKeyHash()->getHex());

//        dd(BitcoinHelper::extractP2pkhAddressFromPublicKeyHash(hex2bin($bitcoinKey->getPublic()->getPubKeyHash()->getHex())));

//        $derPublic = $this->publicKeyToDer($public);
//        $addressEntity->setPublicKey(base64_encode($derPublic));
        $this->getEntityManager()->persist($addressEntity);

        $transactionEntity = new TransactionEntity();
        $transactionEntity->setAmount($amount);
        $transactionEntity->setToAddress($toAddress);
        // todo: validate address
        $transactionEntity->setFromAddress($network->getAddress());
        $transactionEntity->setPayload($this->getPayload($transactionEntity));


        $digest = $this->getDigest($transactionEntity);
        $transactionEntity->setDigest($digest);
        $serializedSig = $this->sign($transactionEntity/*, $private*/);
        $transactionEntity->setSignature($serializedSig);

        ValidationHelper::validateEntity($transactionEntity);
//        dd($transactionEntity);
        $this->verify($transactionEntity/*, $public*/);


        $this->getEntityManager()->persist($transactionEntity);
//        $transactionEntity1 = EntityHelper::createEntity(TransactionEntity::class, EntityHelper::toArray($transactionEntity));
        $transactionEntity1 = $this->getEntityManager()->oneById(TransactionEntity::class, $transactionEntity->getId());

//        dd($transactionEntity, $transactionEntity1);
        $this->verify($transactionEntity1);

        return $transactionEntity;
    }

    private function verify(TransactionEntity $transactionEntity): void
    {
        ValidationHelper::validateEntity($transactionEntity);

        $signaturePem = $transactionEntity->getSignature();
        $address = $transactionEntity->getFromAddress();

//        $bitcoinKey = new BitcoinKey($this->privateKeyWif);
//        $isValid = $bitcoinKey->isVerify($signaturePem, $address);
        $isValid = BitcoinHelper::isVerify($signaturePem, $address);
        if (!$isValid) {
            throw new \Exception('Not verify signature!');
        }



//        $query = new Query();
//        $query->where('address', $transactionEntity->getFromAddress());
//        /** @var AddressEntity $addressEntity */
//        $addressEntity = $this->getEntityManager()->one(AddressEntity::class, $query);

//        $adapter = EccFactory::getAdapter();
//        $pemPublicKeySerializer = new PemPublicKeySerializer(new DerPublicKeySerializer($adapter));
//        $public = $pemPublicKeySerializer->parse($addressEntity->getPublicKey());
//        $this->verifyByPublicKey($transactionEntity/*, $public*/);
    }

//    private function verifyByPublicKey(TransactionEntity $transactionEntity/*, PublicKeyInterface $public*/): void
//    {
//
//    }

    private function sign(TransactionEntity $transactionEntity/*, PrivateKeyInterface $private*/)
    {
        $bitcoinKey = new BitcoinKey($this->privateKeyWif);
        $c14n = new C14n(['sort-string', 'json-unescaped-unicode']);
        $message = $c14n->encode($transactionEntity->getPayload());
        return $bitcoinKey->sign($message);
    }

    private function verifyByPublicKey_(TransactionEntity $transactionEntity, PublicKeyInterface $public): void
    {
        ValidationHelper::validateEntity($transactionEntity);
//        dd($transactionEntity);
        $expectedDigest = $this->getDigest($transactionEntity);
//        dd((string) $transactionEntity->getDigest() , (string)$expectedDigest);
        if ($transactionEntity->getDigest() != $expectedDigest) {
            throw new \Exception('Bad digest! ' . $transactionEntity->getDigest() . ' != ' . $expectedDigest);
        }
        $adapter = EccFactory::getAdapter();
        $sigSerializer = new DerSignatureSerializer();
        $sig = $sigSerializer->parse($transactionEntity->getSignature());

        $hashGmp = $transactionEntity->getDigest();
        $signer = new Signer($adapter);
        $check = $signer->verify($public, $sig, $hashGmp);
        if (!$check) {
            throw new \Exception('Not verify signature!');
        }
    }

    private function sign_(TransactionEntity $transactionEntity, PrivateKeyInterface $private)
    {
        /** @var GMP $hashGmp */
        $hashGmp = $transactionEntity->getDigest();
        $useDerandomizedSignatures = true;
        $algorithm = 'sha256';

        # Derandomized signatures are not necessary, but is avoids
        # the risk of a low entropy RNG, causing accidental reuse
        # of a k value for a different message, which leaks the
        # private key.
        if ($useDerandomizedSignatures) {
            $random = \Mdanter\Ecc\Random\RandomGeneratorFactory::getHmacRandomGenerator($private, $hashGmp, $algorithm);
        } else {
            $random = \Mdanter\Ecc\Random\RandomGeneratorFactory::getRandomGenerator();
        }
        $generator = EccFactory::getNistCurves()->generator384();
        $randomK = $random->generate($generator->getOrder());

        $adapter = EccFactory::getAdapter();
        $signer = new Signer($adapter);
        $signature = $signer->sign($private, $hashGmp, $randomK);

        $serializer = new DerSignatureSerializer();
        $serializedSig = $serializer->serialize($signature);
        return $serializedSig;
    }
}
