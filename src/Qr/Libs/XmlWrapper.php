<?php

namespace ZnSandbox\Sandbox\Qr\Libs;

use ZnCrypt\Base\Domain\Libs\Encoders\EncoderInterface;
use ZnLib\Egov\Helpers\XmlHelper;
use ZnSandbox\Sandbox\Qr\Entities\BarCodeEntity;

class XmlWrapper //implements EncoderInterface
{

    public function encode(BarCodeEntity $entity)
    {
        $barCode = [
            "@xmlns" => "http://barcodes.pdf.shep.nitec.kz/",
        ];
        $barCode['creationDate'] = $entity->getCreatedAt();
        $barCode['elementData'] = $entity->getData();
        $barCode['elementNumber'] = $entity->getId();
        $barCode['elementsAmount'] = $entity->getCount();
        $barCode['FavorID'] = 10100464053940;
        return XmlHelper::encode(['BarcodeElement' => $barCode]);
    }

    public function decode($encodedData): BarCodeEntity
    {
        $decoded = XmlHelper::decode($encodedData);
        $entity = new BarCodeEntity();
        $entity->setId($decoded['BarcodeElement']['elementNumber']);
        $entity->setCount($decoded['BarcodeElement']['elementsAmount']);
        $entity->setData($decoded['BarcodeElement']['elementData']);
        $entity->setCreatedAt($decoded['BarcodeElement']['creationDate']);
        return $entity;
    }
}