<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Helper;

use BitcoinPHP\BitcoinECDSA\BitcoinECDSA;
use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Address\SegwitAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\EcAdapter\EcSerializer;
use BitWasp\Bitcoin\Crypto\EcAdapter\Key\PublicKeyInterface;
use BitWasp\Bitcoin\Crypto\EcAdapter\Serializer\Signature\CompactSignatureSerializerInterface;
use BitWasp\Bitcoin\MessageSigner\MessageSigner;
use BitWasp\Bitcoin\MessageSigner\SignedMessage;
use BitWasp\Bitcoin\Network\NetworkInterface;
use BitWasp\Bitcoin\Script\WitnessProgram;
use BitWasp\Bitcoin\Serializer\MessageSigner\SignedMessageSerializer;
use BitWasp\Buffertools\Buffer;

class BitcoinHelper
{

    public static function parseAddress(string $addressBase58)
    {
        $bitcoinECDSA = new BitcoinECDSA();
        $addressHex = $bitcoinECDSA->base58_decode($addressBase58);
        $addressBinary    = hex2bin($addressHex);
        if(strlen($addressBinary) !== 25) {
            return false;
        }
        $checksum   = substr($addressBinary, 21, 4);
        $rawAddress = substr($addressBinary, 0, 21);
        $checksumCalculated = substr(hex2bin($bitcoinECDSA->hash256($rawAddress)), 0, 4);

        return [
            'addressChecksum' => $checksum,
            'addressHashRaw' => $rawAddress,
            'addressHashHex' => bin2hex($rawAddress),
            'checksumCalculated' => $checksumCalculated,
            'isValidChecksum' => $checksumCalculated === $checksum,
        ];
    }

    public static function validateAddress(string $address): void {
        if(!self::isValidAddress($address)) {
            throw new \Exception('to address not valid!');
        }
    }

    public static function isValidAddress(string $address): bool {
        $bitcoinECDSA = new BitcoinECDSA();
        return $bitcoinECDSA->validateAddress($address);
    }

    public static function isValidWifAddress(string $address): bool {
        $bitcoinECDSA = new BitcoinECDSA();
        return $bitcoinECDSA->validateWifKey($address);
    }

    private static function parseSignature(string $signaturePem): SignedMessage
    {
        /** @var CompactSignatureSerializerInterface $compactSigSerializer */
        $compactSigSerializer = EcSerializer::getSerializer(CompactSignatureSerializerInterface::class);
        $serializer = new SignedMessageSerializer($compactSigSerializer);
        $signedMessage = $serializer->parse($signaturePem);
        return $signedMessage;
    }

    public static function parseRawMessage(string $rawMessage)
    {
        preg_match_all("#-----BEGIN BITCOIN SIGNED MESSAGE-----\n(.{0,})\n-----BEGIN SIGNATURE-----\n#USi", $rawMessage, $out);
        $message = $out[1][0];
        $address = null;

        preg_match_all("#\n-----BEGIN SIGNATURE-----\n(.{0,})\n(.{0,})\n-----END BITCOIN SIGNED MESSAGE-----#USi", $rawMessage, $out);
        if(isset($out[2][0])) {
            $address = $out[1][0];
            $signature = $out[2][0];
        } else {
            preg_match_all("#\n-----BEGIN SIGNATURE-----\n(.{0,})\n-----END BITCOIN SIGNED MESSAGE-----#USi", $rawMessage, $out);
            $signature = $out[1][0];
        }
        return [
            'message' => $message,
            'address' => $address,
            'signature' => $signature,
        ];
    }

    public static function checkSignatureForRawMessage(string $rawMessage, string $address = null)
    {
        $parsedMessage = self::parseRawMessage($rawMessage);
        $bitcoinECDSA = new BitcoinECDSA();
        return $bitcoinECDSA->checkSignatureForMessage($parsedMessage['address'] ?? $address, $parsedMessage['signature'], $parsedMessage['message']);
    }

    public static function isVerify(string $signaturePem, string $address): bool {
//        return self::checkSignatureForRawMessage($signaturePem, $address);

        $addrCreator = new AddressCreator();
        /** @var PayToPubKeyHashAddress $payToPubKeyHashAddress */
        $payToPubKeyHashAddress = $addrCreator->fromString($address);
        $publicKey = BitcoinHelper::extractPublicKey($signaturePem);
        return $publicKey->getPubKeyHash()->equals($payToPubKeyHashAddress->getHash());
    }

    public static function extractP2pkhAddressFromPublicKeyHash(string $binaryHash): string
    {
        $buf = new Buffer($binaryHash);
        $p2pkh = new PayToPubKeyHashAddress($buf);
        return $p2pkh->getAddress();
    }

    public static function extractP2pkhAddressFromSignature(string $signaturePem, NetworkInterface $network = null): string
    {
        $publicKey = BitcoinHelper::extractPublicKey($signaturePem);
        $pubKeyHash = $publicKey->getPubKeyHash();
        $p2pkh = new PayToPubKeyHashAddress($pubKeyHash);
        return $p2pkh->getAddress();
    }

    public static function extractSegwitAddressFromSignature(string $signaturePem, NetworkInterface $network = null): string
    {
        $publicKey = BitcoinHelper::extractPublicKey($signaturePem);
        $pubKeyHash = $publicKey->getPubKeyHash();
//        $p2pkh = new PayToPubKeyHashAddress($pubKeyHash);
        $p2wpkhWP = WitnessProgram::v0($pubKeyHash);
        $p2wpkh = new SegwitAddress($p2wpkhWP);
        return $p2wpkh->getAddress();
    }

    public static function extractPublicKey(string $signaturePem, NetworkInterface $network = null): PublicKeyInterface
    {
        $signedMessage = self::parseSignature($signaturePem);
        return self::extractPublicKeyBySignedMessage($signedMessage, $network);

        /*$pubKeyHash = $publicKey->getPubKeyHash();
        $masterAddr = new PayToPubKeyHashAddress($pubKeyHash);
        dd($masterAddr->getAddress());
        return $publicKey->getPubKeyHash()->equals($address->getHash());*/
    }

    public static function extractPublicKeyBySignedMessage(SignedMessage $signedMessage, NetworkInterface $network = null): PublicKeyInterface
    {
        $ecAdapter = Bitcoin::getEcAdapter();
        $signer = new MessageSigner($ecAdapter);
        $network = $network ?: Bitcoin::getNetwork();

        $hash = $signer->calculateMessageHash($network, $signedMessage->getMessage());
        $publicKey = $ecAdapter->recover(
            $hash,
            $signedMessage->getCompactSignature()
        );
        return $publicKey;
    }
}
