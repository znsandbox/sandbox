<?php

namespace ZnSandbox\Sandbox\Cert\Domain\Services;

use phpseclib\File\X509;
use phpseclib\Crypt\RSA;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnSandbox\Sandbox\Cert\Domain\Entities\InfoEntity;
use ZnSandbox\Sandbox\Cert\Domain\Entities\PersonEntity;
use ZnSandbox\Sandbox\Cert\Domain\Entities\SignatureEntity;
use ZnSandbox\Sandbox\Cert\Domain\Helpers\NcaLayerHelper;
use ZnSandbox\Sandbox\Cert\Domain\Helpers\X509Helper;
use ZnSandbox\Sandbox\Cert\Domain\Helpers\XmlHelper;

class SignatureService
{

    private $x509;

    public function __construct(string $ca)
    {
        $this->x509 = new X509();
        $this->x509->loadCA($ca);
    }

    public function getInfo(string $xml): InfoEntity
    {
        $infoEntity = new InfoEntity();
        $signatureEntity = NcaLayerHelper::parseXmlSignature($xml);
        $certArray = $this->x509->loadX509($signatureEntity->getCertificatePemFormat());
        $infoEntity->setPerson(X509Helper::parsePerson($certArray));
        $infoEntity->setIsAuthenticCertificate($this->x509->validateSignature());
        $pubKey = $certArray['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey'];
        $infoEntity->setIsAuthenticSignature($this->isVerifySignature($signatureEntity->getCertificatePemFormat(), $signatureEntity));
        $infoEntity->setSignature($signatureEntity);
        return $infoEntity;
    }

    public function check(InfoEntity $infoEntity)
    {
        if( ! $infoEntity->getIsAuthenticCertificate()) {
            throw new \Exception('Certificate signature not verified!');
        }
        if( ! $infoEntity->getIsAuthenticSignature()) {
            //throw new \Exception('Content signature not verified!');
        }
    }

    private function isVerifySignature(string $pubKey, SignatureEntity $signatureEntity): bool
    {
        $plaintext = base64_decode($signatureEntity->getDigest());
        $signature = base64_decode($signatureEntity->getSignature());

        $pubkeyid = openssl_get_publickey($pubKey);
        $keyData = openssl_pkey_get_details($pubkeyid);

        $rsa = new RSA();
        $rsa->loadKey($keyData['key']); // private key
        $rsa->setHash('sha256');

//        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        //dd($pubKey);
//        return $rsa->verify($plaintext, $signature);

        //($keyData['key']);
        return openssl_verify($plaintext, $signature, $pubkeyid, OPENSSL_ALGO_SHA256);
    }
}
