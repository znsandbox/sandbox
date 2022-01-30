<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Services;

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
use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Repositories\TransactionRepositoryInterface;
use ZnSandbox\Sandbox\BlockChain\Domain\Interfaces\Services\TransactionServiceInterface;
use GMP;

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

    private function loadPublicFromPemFile(string $file): PublicKeyInterface
    {
        $adapter = EccFactory::getAdapter();
        $pemPublicKeySerializer = new PemPublicKeySerializer(new DerPublicKeySerializer($adapter));
        $pemPublic = file_get_contents($this->publicPemFile);
        $public = $pemPublicKeySerializer->parse($pemPublic);
        return $public;
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

        $c14n = new C14n(['sort-string', 'json-unescaped-unicode']);
        $canonicalJson = $c14n->encode($data);
        //dd($canonicalJson);
        $gmp = $hasher->makeHash($canonicalJson, $generator);
        return $gmp;
//        $hash = gmp_strval($gmp, 16);
//        return gmp_init($hash, 10);
    }

    public function send(string $privateKey, string $toAddress, int $amount): TransactionEntity
    {
        $private = $this->loadPrivateFromPemFile(__DIR__ . '/../../../../../../../var/ecc/keys/private.pem');
        $public = $private->getPublicKey();




        /* $derPublic = $this->publicKeyToDer($public);
         $ec = Bitcoin::getEcAdapter();
         $pub = new PublicKey($ec, $public->getPoint());
         dd($pub->getPubKeyHash());
         $buf = new Buffer($derPublic);
 //        dd($buf->getBinary());
         $th = Hash::sha256ripe160($buf);
         $fromAddr = new PayToPubKeyHashAddress($th);*/
        /*
                $bufferTo = Base58::decode($toAddress);
        //        dd($buffer->getHex());
        //        $aa = Base58::encode($buffer);
        //        dd($aa, $toAddress);
                $th1 = Hash::sha256ripe160($bufferTo);
                $toAddr = new PayToPubKeyHashAddress($th1);

                dd($buf, $fromAddr->getAddress(), $th, $bufferTo->getHex(), $toAddr->getAddress());*/


//        $network = $this->publicKeyToAddress($public);
        $network = $this->getAddr();

        $addressEntity = new AddressEntity();
        $addressEntity->setAddress($network->getAddress());
        $addressEntity->setHash(Base58::decode($network->getAddress())->getHex());
        $addressEntity->setPublicKey(base64_encode($this->getPublic()->getBinary()));
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
        $serializedSig = $this->sign($transactionEntity, $private);
        $transactionEntity->setSignature($serializedSig);

        ValidationHelper::validateEntity($transactionEntity);
//        dd($transactionEntity);
        $this->verifyByPublicKey($transactionEntity, $public);


        $this->getEntityManager()->persist($transactionEntity);
//        $transactionEntity1 = EntityHelper::createEntity(TransactionEntity::class, EntityHelper::toArray($transactionEntity));
        $transactionEntity1 = $this->getEntityManager()->oneById(TransactionEntity::class, $transactionEntity->getId());

//        dd($transactionEntity, $transactionEntity1);
        $this->verify($transactionEntity1);

        return $transactionEntity;
    }

    private function verify(TransactionEntity $transactionEntity): void
    {
        $query = new Query();
        $query->where('address', $transactionEntity->getFromAddress());
        /** @var AddressEntity $addressEntity */
        $addressEntity = $this->getEntityManager()->one(AddressEntity::class, $query);

//        $adapter = EccFactory::getAdapter();
//        $pemPublicKeySerializer = new PemPublicKeySerializer(new DerPublicKeySerializer($adapter));
//        $public = $pemPublicKeySerializer->parse($addressEntity->getPublicKey());
        $this->verifyByPublicKey($transactionEntity/*, $public*/);
    }

    private function verifyByPublicKey(TransactionEntity $transactionEntity/*, PublicKeyInterface $public*/): void
    {
        ValidationHelper::validateEntity($transactionEntity);

        /*$privFactory = new PrivateKeyFactory();
        $priv = $privFactory->fromWif('Kwoii6A3caGLhVfms1c8KnxnqGVzaZjLJfguDvzJvBiTbzBCHKKB');
        $publicKey = $priv->getPublicKey();
        $pubKeyHash = $publicKey->getPubKeyHash();
        $masterAddr = new PayToPubKeyHashAddress($pubKeyHash);*/

        $addrCreator = new AddressCreator();
        $masterAddr = $addrCreator->fromString($transactionEntity->getFromAddress());

        //dd($masterAddr->getAddress());

        $addrCreator = new AddressCreator();
        /** @var PayToPubKeyHashAddress $payToPubKeyHashAddress */
        $payToPubKeyHashAddress = $addrCreator->fromString($transactionEntity->getFromAddress());
        //dd($payToPubKeyHashAddress);

        /** @var CompactSignatureSerializerInterface $compactSigSerializer */
        $compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
        $serializer = new SignedMessageSerializer($compactSigSerializer);

//        dd($transactionEntity);
        $signedMessage = $serializer->parse($transactionEntity->getSignature());
//        dd($signedMessage->getBuffer()->getBinary());
        $signer = new MessageSigner();
        $isValid = $signer->verify($signedMessage, $masterAddr);
        if (!$isValid) {
            throw new \Exception('Not verify signature!');
        }
//        dd($isValid);
        /*if ($isValid) {
            $this->alertSuccess('Signature verified!');
        } else {
            $this->alertDanger('Failed to verify signature!');
        }*/
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

//        $hashGmp = gmp_init($transactionEntity->getDigest(), 10);
        $hashGmp = $transactionEntity->getDigest();
//dd($hashGmp);
        $signer = new Signer($adapter);
        $check = $signer->verify($public, $sig, $hashGmp);
        if (!$check) {
            throw new \Exception('Not verify signature!');
        }
    }

    private function getPrivate(): \BitWasp\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface
    {
        $privFactory = new PrivateKeyFactory();
        $priv = $privFactory->fromWif('Kwoii6A3caGLhVfms1c8KnxnqGVzaZjLJfguDvzJvBiTbzBCHKKB');
        return $priv;
    }

    private function getPublic(): \BitWasp\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface
    {
        $priv = $this->getPrivate();
        $publicKey = $priv->getPublicKey();
        return $publicKey;
    }

    private function getAddr(): PayToPubKeyHashAddress
    {
        $publicKey = $this->getPublic();
        $pubKeyHash = $publicKey->getPubKeyHash();
        $masterAddr = new PayToPubKeyHashAddress($pubKeyHash);
        return $masterAddr;
    }

    private function sign(TransactionEntity $transactionEntity, PrivateKeyInterface $private)
    {
        $priv = $this->getPrivate();
//        $pubKeyHash = $publicKey->getPubKeyHash();
//        $masterAddr = new PayToPubKeyHashAddress($pubKeyHash);
//        dd($masterAddr->getAddress());

        $ec = Bitcoin::getEcAdapter();
//        $random = new Random();
//        $privKeyFactory = new PrivateKeyFactory($ec);
//        $privateKey = $privKeyFactory->generateCompressed($random);

        $c14n = new C14n(['sort-string', 'json-unescaped-unicode']);
        $message = $c14n->encode($transactionEntity->getPayload());

        //dd($message);

        $signer = new MessageSigner($ec);
        $signed = $signer->sign($message, $priv);
        return $signed->getBuffer()->getBinary();

        dd($signed->getBuffer()->getBinary());
        $signatureBinary = $signed->getCompactSignature()->getBinary();
//        dd($signatureBinary);
        return $signatureBinary;


        //dump($priv->getPublicKey()->getPubKeyHash());
        $payToPubKeyHashAddress = new PayToPubKeyHashAddress($priv->getPublicKey()->getPubKeyHash());
//        dd($payToPubKeyHashAddress->getAddress());

        /** @var CompactSignatureSerializerInterface $compactSigSerializer */
//        $compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
//        $serializer = new SignedMessageSerializer($compactSigSerializer);
//        $signedMessage = $serializer->parse($signed->getBuffer()->getBinary());

        dump($signatureBinary);

//        dd($signedMessage->getCompactSignature()->getBinary());
//        dd($signedMessage->getMessage());

        dump($payToPubKeyHashAddress->getAddress());
        dd($signed->getBuffer()->getBinary());

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

    private function getRandom()
    {

    }
}
