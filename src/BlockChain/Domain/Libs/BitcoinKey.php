<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Libs;

use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PrivateKeyInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\MessageSigner\SignedMessage;
use BitWasp\Bitcoin\Network\NetworkInterface;
use BitWasp\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;
use ZnSandbox\Sandbox\BlockChain\Domain\Helper\BitcoinHelper;

class BitcoinKey
{

    private $privateKeyWif;

    public function __construct(string $privateKeyWif)
    {
        $this->privateKeyWif = $privateKeyWif;
    }

    public function getPrivate(): PrivateKeyInterface
    {
        $privFactory = new PrivateKeyFactory();
        $priv = $privFactory->fromWif($this->privateKeyWif);
        return $priv;
    }

    public function getPublic(): PublicKeyInterface
    {
        $priv = $this->getPrivate();
        $publicKey = $priv->getPublicKey();
        return $publicKey;
    }

    public function getAddr(): PayToPubKeyHashAddress
    {
        $publicKey = $this->getPublic();
        $pubKeyHash = $publicKey->getPubKeyHash();
        $masterAddr = new PayToPubKeyHashAddress($pubKeyHash);
        return $masterAddr;
    }

    public function sign(string $message): string
    {
        $ec = Bitcoin::getEcAdapter();
        $signer = new MessageSigner($ec);
        $signed = $signer->sign($message, $this->getPrivate());
        return $signed->getBuffer()->getBinary();
    }

    public function isVerify(string $signaturePem, string $address): bool {
        $addrCreator = new AddressCreator();
        /** @var PayToPubKeyHashAddress $payToPubKeyHashAddress */
        $payToPubKeyHashAddress = $addrCreator->fromString($address);

//        /** @var CompactSignatureSerializerInterface $compactSigSerializer */
//        $compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
//        $serializer = new SignedMessageSerializer($compactSigSerializer);
//        $signedMessage = $serializer->parse($signaturePem);

//        dd($signedMessage->getBuffer()->getBinary());
//        $signer = new MessageSigner();
//        $isValid = $signer->verify($signedMessage, $payToPubKeyHashAddress);

        $publicKey = BitcoinHelper::extractPublicKey($signaturePem);
        return $publicKey->getPubKeyHash()->equals($payToPubKeyHashAddress->getHash());
    }

//    public function extractPublicKey(SignedMessage $signedMessage, NetworkInterface $network = null): PublicKeyInterface
//    {
//        $ecAdapter = Bitcoin::getEcAdapter();
//        $signer = new MessageSigner($ecAdapter);
//        $network = $network ?: Bitcoin::getNetwork();
//        $hash = $signer->calculateMessageHash($network, $signedMessage->getMessage());
//        $publicKey = $ecAdapter->recover(
//            $hash,
//            $signedMessage->getCompactSignature()
//        );
//        return $publicKey;
//
//        /*$pubKeyHash = $publicKey->getPubKeyHash();
//        $masterAddr = new PayToPubKeyHashAddress($pubKeyHash);
//        dd($masterAddr->getAddress());
//        return $publicKey->getPubKeyHash()->equals($address->getHash());*/
//    }
}
