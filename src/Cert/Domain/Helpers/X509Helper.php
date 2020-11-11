<?php

namespace ZnSandbox\Sandbox\Cert\Domain\Helpers;

use phpseclib\File\X509;
use SimpleXMLElement;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnSandbox\Sandbox\Cert\Domain\Entities\PersonEntity;

class X509Helper
{

    public static function parsePerson(array $cert): PersonEntity
    {
        $person = self::getAssocFromCert($cert);
        $personEntity = self::createPersonEntity($person);
        return $personEntity;
    }

    public static function createPersonEntity(array $person): PersonEntity
    {
        $person['name'] = trim(str_replace($person['surname'], '', $person['commonName']));
        $person['code'] = str_replace('IIN', '', $person['serialNumber']);
        $personEntity = new PersonEntity();
        $personEntity->setName($person['name']);
        $personEntity->setSurname($person['surname']);
        $personEntity->setPatronymic($person['givenName']);
        $personEntity->setCode($person['code']);
        $personEntity->setEmail($person['emailAddress']);
        return $personEntity;
    }

    public static function getAssocFromCert(array $cert): array
    {
        /*$person = [];
        foreach ($cert['tbsCertificate']['subject']['rdnSequence'] as $item) {
            $value = $item[0]['value'];
            $type = $item[0]['type'];
            $key = preg_replace('/^[\s\S]*-at-/', '', $type);
            $person[$key] = ArrayHelper::first($value);
        }*/
        $person = self::getAssoc($cert['tbsCertificate']['subject']['rdnSequence']);
        $person['name'] = trim(str_replace($person['surname'], '', $person['commonName']));
        $person['code'] = str_replace('IIN', '', $person['serialNumber']);
        return $person;
    }

    public static function cleanParams(array $params): array
    {
        $arr = [];
        foreach ($params as $key => $value) {
            if($key === 'null' && empty($value)) {
                unset($params[$key]);
            }
        }
        return $params;
    }

    public static function getAssoc(array $rdnSequence): array
    {
        $arr = [];
        foreach ($rdnSequence as $item) {
            $value = $item[0]['value'];
            $type = $item[0]['type'];
            $key = preg_replace('/^[\s\S]*-at-/', '', $type);
            $arr[$key] = ArrayHelper::first($value);
        }
        return $arr;
    }
}
