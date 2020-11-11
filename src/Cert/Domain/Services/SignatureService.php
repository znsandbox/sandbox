<?php

namespace ZnSandbox\Sandbox\Cert\Domain\Services;

use phpseclib\File\X509;
use phpseclib\Crypt\RSA;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnSandbox\Sandbox\Cert\Domain\Entities\PersonEntity;
use ZnSandbox\Sandbox\Cert\Domain\Entities\SignatureEntity;
use ZnSandbox\Sandbox\Cert\Domain\Helpers\XmlHelper;

class SignatureService
{

    /*private $repository;
    private $hostsRepository;

    public function __construct(ServerRepository $repository, HostsRepository $hostsRepository)
    {
        $this->repository = $repository;
        $this->hostsRepository = $hostsRepository;
    }*/

    public function verifyCert(string $x509Data)
    {
        $x509 = new X509();
        $x509->loadCA(file_get_contents('/home/vitaliy/common/var/www/codo/rpc/var/nca_rsa.crt')); // see signer.crt
        $cert = $x509->loadX509($x509Data); // see google.crt
        if (!$x509->validateSignature()) {
            throw new \Exception('Bad validate certificate signature');
        }
    }

    public function getPublicKeyFromCert(string $x509Data)
    {
        $x509 = new X509();
        $cert = $x509->loadX509($x509Data); // see google.crt
        $pubKey = $cert['tbsCertificate']['subjectPublicKeyInfo']['subjectPublicKey'];
        return $pubKey;
    }

    public function getPersonFromCert(string $x509Data): PersonEntity
    {
        $x509 = new X509();
        $cert = $x509->loadX509($x509Data); // see google.crt

        $person = [];
        foreach ($cert['tbsCertificate']['subject']['rdnSequence'] as $item) {
            $value = $item[0]['value'];
            $type = $item[0]['type'];
            $key = preg_replace('/^[\s\S]*-at-/', '', $type);
            $person[$key] = ArrayHelper::first($value);
        }

        $person['name'] = trim(str_replace($person['surname'], '', $person['commonName']));

        //dd($person);

        $personEntity = new PersonEntity();
        $personEntity->setName($person['name']);
        $personEntity->setSurname($person['surname']);
        $personEntity->setPatronymic($person['givenName']);
        $personEntity->setCode(str_replace('IIN', '', $person['serialNumber']));
        $personEntity->setEmail($person['emailAddress']);

        //dd($personEntity);

        return $personEntity;
    }

    public function getDataFromCert(string $x509Data)
    {
        $x509 = new X509();
        $cert = $x509->loadX509($x509Data); // see google.crt
        return $cert;
    }

    public function verifySignature($plaintext, $signature, $pubKey)
    {
        $rsa = new RSA();
//$rsa->setPassword('password');
        $rsa->loadKey($pubKey); // private key
        $rsa->setHash('sha256');
        dump($rsa->verify(base64_decode($plaintext), $signature) ? 'verified' : 'unverified');
        dd($rsa->verify($plaintext, $signature) ? 'verified' : 'unverified');
    }


}
