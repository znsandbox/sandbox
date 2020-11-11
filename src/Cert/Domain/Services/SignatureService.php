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

    private $xml;
    private $x509;
    private $signatureEntity;
    private $certArray;

    public function __construct(string $ca)
    {
//        $this->xml = $xml;
        $this->x509 = new X509();
        $this->x509->loadCA($ca);
//        $this->signatureEntity = NcaLayerHelper::parseXmlSignature($xml);

        //$this->verifyCaSignatureInCertificate();
    }

    public function getInfo(string $xml): InfoEntity
    {
        $infoEntity = new InfoEntity();
        $this->signatureEntity = NcaLayerHelper::parseXmlSignature($xml);
        $this->certArray = $this->x509->loadX509($this->signatureEntity->getCertificatePemFormat());
        $infoEntity->setPerson(X509Helper::parsePerson($this->certArray));
        $infoEntity->setIsAuthenticCertificate($this->x509->validateSignature());
//        $pubKey = $this->getPublicKeyFromCert();
        $pubKey = $this->certArray['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey'];
        //$signatureEntity = $this->getSignatureEntity();
        $infoEntity->setIsAuthenticSignature($this->isVerifySignature($pubKey, $this->signatureEntity));
        $infoEntity->setSignature($this->signatureEntity);
        return $infoEntity;
    }

    /*public function getSignatureEntity(): SignatureEntity
    {
        return $this->signatureEntity;
    }

    public function verifyCaSignatureInCertificate()
    {
        if (!$this->x509->validateSignature()) {
            throw new \Exception('Bad validate certificate signature');
        }
    }

    public function getPublicKeyFromCert()
    {
        $pubKey = $this->certArray['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey'];
        return $pubKey;
    }

    public function getPersonFromCert(): PersonEntity
    {
        return X509Helper::parsePerson($this->certArray);
    }*/

    public function isVerifySignature(string $pubKey, SignatureEntity $signatureEntity): bool
    {
        $plaintext = base64_decode($signatureEntity->getDigest());
        $signature = base64_decode($signatureEntity->getSignature());

        $rsa = new RSA();
        $rsa->loadKey($pubKey); // private key
        $rsa->setHash('sha256');
        return $rsa->verify($plaintext, $signature);
    }
}
