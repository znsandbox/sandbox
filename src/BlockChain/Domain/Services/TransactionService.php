<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Services;

use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Crypto\Hash;
use BitWasp\Buffertools\Buffer;
use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\Crypto\Signature\Signer;
use Mdanter\Ecc\Crypto\Signature\SignHasher;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Mdanter\Ecc\Serializer\Signature\DerSignatureSerializer;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Helpers\ValidationHelper;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCrypt\Pki\JsonDSig\Domain\Libs\C14n;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\AddressEntity;
use ZnSandbox\Sandbox\BlockChain\Domain\Entities\TransactionEntity;
use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Repositories\TransactionRepositoryInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Services\TransactionServiceInterface;

/**
 * @method TransactionRepositoryInterface getRepository()
 */
class TransactionService extends BaseCrudService implements TransactionServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return TransactionEntity::class;
    }

    private function loadPrivateFromPemFile(string $file): PrivateKeyInterface
    {
        $adapter = EccFactory::getAdapter();
        $pemPrivateKeySerializer = new PemPrivateKeySerializer(new DerPrivateKeySerializer($adapter));
        $pemPrivate = file_get_contents($file);
        $private = $pemPrivateKeySerializer->parse($pemPrivate);
        return $private;
    }

    public function publicKeyToDer(PublicKeyInterface $public): string
    {
        $adapter = EccFactory::getAdapter();
        $derPublicKeySerializer = new DerPublicKeySerializer($adapter);
        $derPublic = $derPublicKeySerializer->serialize($public);
        return $derPublic;
    }

    public function publicKeyToAddress(PublicKeyInterface $public): PayToPubKeyHashAddress
    {
        $derPublic = $this->publicKeyToDer($public);
        $buf = new Buffer($derPublic);
        $th = Hash::sha256ripe160($buf);
        $masterAddr = new PayToPubKeyHashAddress($th);
        return $masterAddr;
    }

    protected function getDigest(TransactionEntity $transactionEntity): string
    {
        $data = [
            'fromAddress' => $transactionEntity->getFromAddress(),
            'toAddress' => $transactionEntity->getToAddress(),
            'amount' => $transactionEntity->getAmount(),
            'createdAt' => $transactionEntity->getCreatedAt()->getTimestamp(),
            'payload' => $transactionEntity->getPayload(),
        ];

//        $adapter = EccFactory::getAdapter();
        $generator = EccFactory::getNistCurves()->generator384();
        $algorithm = 'sha256';

        $hasher = new SignHasher($algorithm);

        $c14n = new C14n(['sort-string', 'json-unescaped-unicode']);
        $canonicalJson = $c14n->encode($data);
        $gmp = $hasher->makeHash($canonicalJson, $generator);
        $hash = gmp_strval($gmp, 16);
        return $hash;
    }

    public function send(string $privateKey, string $toAddress, int $amount): TransactionEntity
    {
        $private = $this->loadPrivateFromPemFile(__DIR__ . '/../../../../../../../var/ecc/keys/private.pem');
        $public = $private->getPublicKey();

        $network = $this->publicKeyToAddress($public);

        $addressEntity = new AddressEntity();
        $addressEntity->setAddress($network->getAddress());
        $derPublic = $this->publicKeyToDer($public);
        $addressEntity->setPublicKey(base64_encode($derPublic));
        $this->getEntityManager()->persist($addressEntity);

        $transactionEntity = new TransactionEntity();
        $transactionEntity->setAmount($amount);
        $transactionEntity->setToAddress($toAddress);
        $transactionEntity->setFromAddress($network->getAddress());
        $digest = $this->getDigest($transactionEntity);
        $transactionEntity->setDigest($digest);
        $serializedSig = $this->sign($transactionEntity->getDigest(), $private);
        $transactionEntity->setSignature(base64_encode($serializedSig));

        ValidationHelper::validateEntity($transactionEntity);

        $check = $this->verifyByPublicKey($transactionEntity, $public);
        if(!$check) {
            throw new \Exception('Signature not verified!');
        }
        $this->getEntityManager()->persist($transactionEntity);
        return $transactionEntity;
    }

    private function verifyByPublicKey(TransactionEntity $transactionEntity, PublicKeyInterface $public): bool
    {
        if ($transactionEntity->getDigest() !== $this->getDigest($transactionEntity)) {
            throw new \Exception('Bad digest!');
        }
        $adapter = EccFactory::getAdapter();
        $sigSerializer = new DerSignatureSerializer();
        $sig = $sigSerializer->parse(base64_decode($transactionEntity->getSignature()));
        $hashGmp = gmp_init($transactionEntity->getDigest(), 16);

        $signer = new Signer($adapter);
        $check = $signer->verify($public, $sig, $hashGmp);
        return $check;
    }

    private function sign(string $digest, PrivateKeyInterface $private)
    {
        $adapter = EccFactory::getAdapter();
        $generator = EccFactory::getNistCurves()->generator384();
        $useDerandomizedSignatures = true;
        $algorithm = 'sha256';

//                    $document = 'I am writing today...';

//        $hasher = new SignHasher($algorithm, $adapter);
//        $hash = $hasher->makeHash($document, $generator);
        $hashGmp = gmp_init($digest, 16);

        # Derandomized signatures are not necessary, but is avoids
        # the risk of a low entropy RNG, causing accidental reuse
        # of a k value for a different message, which leaks the
        # private key.
        if ($useDerandomizedSignatures) {
            $random = \Mdanter\Ecc\Random\RandomGeneratorFactory::getHmacRandomGenerator($private, $hashGmp, $algorithm);
        } else {
            $random = \Mdanter\Ecc\Random\RandomGeneratorFactory::getRandomGenerator();
        }
        $randomK = $random->generate($generator->getOrder());

        $signer = new Signer($adapter);
        $signature = $signer->sign($private, $hashGmp, $randomK);

        $serializer = new DerSignatureSerializer();

        $serializedSig = $serializer->serialize($signature);
        return $serializedSig;
        dd($serializedSig);
    }
}
