<?php

namespace ZnSandbox\Sandbox\Qr\Wrappers;

use ZnLib\Egov\Helpers\XmlHelper;
use ZnSandbox\Sandbox\Qr\Entities\BarCodeEntity;

class JsonWrapper implements WrapperInterface
{

    public function isMatch(string $encodedData): bool
    {
        return preg_match('#\{"#i', $encodedData);
    }

    public function encode(BarCodeEntity $entity): string
    {
        $barCode = [];
        $barCode['id'] = $entity->getId();
        $barCode['count'] = $entity->getCount();
        $barCode['data'] = $entity->getData();
        $barCode['creationDate'] = $entity->getCreatedAt();
//        $barCode['FavorID'] = 10100464053940;
        $jsonContent = json_encode($barCode);
        return /*'<?json?>' .*/ $jsonContent;
    }

    public function decode(string $encodedData): BarCodeEntity
    {
        /*$encodedData = preg_replace('#<\?[\s\S]+\?>#i', '', $encodedData);*/

        $decoded = json_decode($encodedData, JSON_OBJECT_AS_ARRAY);
        $entity = new BarCodeEntity();
        $entity->setId($decoded['id']);
        $entity->setCount($decoded['count']);
        $entity->setData($decoded['data']);
        $entity->setCreatedAt($decoded['creationDate']);
        return $entity;
    }
}
