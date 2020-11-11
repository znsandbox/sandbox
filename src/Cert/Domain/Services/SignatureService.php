<?php

namespace ZnSandbox\Sandbox\Cert\Domain\Services;

use phpseclib\File\X509;
use phpseclib\Crypt\RSA;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnSandbox\Sandbox\Cert\Domain\Entities\CertificateEntity;
use ZnSandbox\Sandbox\Cert\Domain\Entities\InfoEntity;
use ZnSandbox\Sandbox\Cert\Domain\Entities\PersonEntity;
use ZnSandbox\Sandbox\Cert\Domain\Entities\SignatureEntity;
use ZnSandbox\Sandbox\Cert\Domain\Helpers\NcaLayerHelper;
use ZnSandbox\Sandbox\Cert\Domain\Helpers\X509Helper;
use ZnSandbox\Sandbox\Cert\Domain\Helpers\XmlHelper;
use DateTime;

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
        /*$stream = stream_context_create (array("ssl" => array("capture_peer_cert" => true)));
        $read = fopen("https://google.com", "rb", false, $stream);
        $cont = stream_context_get_params($read);
        $cert = ($cont["options"]["ssl"]["peer_certificate"]);
        $certData = openssl_x509_parse($cert);
        openssl_x509_export($cert, $certPem);
        openssl_x509_free( $cert );
        $certArray = $this->x509->loadX509($certPem);
        dd($this->x509->validateSignature());*/
//        dd($certArray);


        $infoEntity = new InfoEntity();
        $signatureEntity = NcaLayerHelper::parseXmlSignature($xml);
        $certArray = $this->x509->loadX509($signatureEntity->getCertificatePemFormat());
        $certificateEntity = new CertificateEntity();
        $certificateEntity->setVersion($certArray['tbsCertificate']['version']);
        $certificateEntity->setIssuer(X509Helper::getAssoc($certArray['tbsCertificate']['issuer']['rdnSequence']));
        $certificateEntity->setSubject(X509Helper::getAssoc($certArray['tbsCertificate']['subject']['rdnSequence']));
        $certificateEntity->setPublicKey($certArray['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey']);
        $certificateEntity->setSerialNumber($certArray['tbsCertificate']['serialNumber']);
        $certificateEntity->setCertificate($signatureEntity->getCertificatePemFormat());
        $certificateEntity->setSignature([
            'algorithm' => $certArray['signatureAlgorithm']['algorithm'],
            'parameters' => X509Helper::cleanParams($certArray['signatureAlgorithm']['parameters']),
            'signatureBase64' => $certArray['signature'],
        ]);
        $certificateEntity->setCreatedAt(new DateTime($certArray['tbsCertificate']['validity']['notBefore']['utcTime']));
        $certificateEntity->setExpiredAt(new DateTime($certArray['tbsCertificate']['validity']['notAfter']['utcTime']));

        //dd($certificateEntity);
//        dd($person = );
        //dd($certArray);

//        dd();
        $infoEntity->setPerson(X509Helper::createPersonEntity($certificateEntity->getSubject()));
        $infoEntity->setCertificate($certificateEntity);
//        $infoEntity->setPerson(X509Helper::parsePerson($certArray));
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


        /*$p = openssl_pkey_get_public($pubKey);
        //dd($p);
        $isVerify = openssl_verify($plaintext, $signature, $p);
        openssl_free_key($p);

        dd($isVerify);*/



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
