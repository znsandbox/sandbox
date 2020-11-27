<?php

namespace ZnSandbox\Sandbox\Qr\Wrappers;

use ZnLib\Egov\Helpers\XmlHelper;
use ZnSandbox\Sandbox\Qr\Entities\BarCodeEntity;

class XmlWrapper implements WrapperInterface
{

    public function isMatch(string $encodedData): bool
    {
//        dd($encodedData);
        return preg_match('#<\?xml#i', $encodedData);
    }

    public function encode(BarCodeEntity $entity): string
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

    public function decode(string $encodedData): BarCodeEntity
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
