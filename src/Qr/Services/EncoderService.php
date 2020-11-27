<?php

namespace ZnSandbox\Sandbox\Qr\Services;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Collection;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCrypt\Base\Domain\Libs\Encoders\Base64Encoder;
use ZnCrypt\Base\Domain\Libs\Encoders\CollectionEncoder;
use ZnCrypt\Pki\X509\Domain\Helpers\QrDecoderHelper;
use ZnLib\Egov\Helpers\XmlHelper;
use ZnSandbox\Sandbox\Qr\Encoders\ImplodeEncoder;
use ZnSandbox\Sandbox\Qr\Encoders\SplitEncoder;
use ZnSandbox\Sandbox\Qr\Encoders\XmlEncoder;
use ZnSandbox\Sandbox\Qr\Entities\BarCodeEntity;
use ZnSandbox\Sandbox\Qr\Libs\ClassEncoder;
use ZnSandbox\Sandbox\Qr\Libs\XmlWrapper;
use ZnSandbox\Sandbox\Qr\Encoders\ZipEncoder;
use Zxing\QrReader;

class EncoderService
{

    private $classEncoder;

    public function __construct(ClassEncoder $classEncoder)
    {
        $this->classEncoder = $classEncoder;
    }

    public function encode($data): Collection
    {
//        dd($data);
        $barCoreEntity1 = new BarCodeEntity();
        $resultEncoder = $this->classEncoder->encodersToClasses([
            //        'xml',
            'zip',
            'implode',
        ]);
        $encoded = $resultEncoder->encode($data);
        $wrapper = new XmlWrapper();
        $collection = new Collection();
        $array = [];
        foreach ($encoded as $index => $item) {
            $entityEncoder = $this->classEncoder->encodersToClasses($barCoreEntity1->getEntityEncoders());
            $encodedItem = $entityEncoder->encode($item);
//            $encodedItem = base64_encode($item);
            $barCodeEntity = new BarCodeEntity();
            $barCodeEntity->setId($index + 1);
            $barCodeEntity->setData($encodedItem);
            $barCodeEntity->setCount(count($encoded));
            $barCodeEntity->setCreatedAt('2020-11-17T20:55:33.671+06:00');
            $collection->add($wrapper->encode($barCodeEntity));
        }
        return $collection;
    }

    public function decode($encodedData)
    {
        $barCodeCollection = $this->arrayToCollection($encodedData);
        $resultCollection = new Collection();
        foreach ($barCodeCollection as $barCodeEntity) {
            $entityEncoders = $this->classEncoder->encodersToClasses($barCodeEntity->getEntityEncoders());
            $decodedItem = $entityEncoders->decode($barCodeEntity->getData());
            $resultCollection->add($decodedItem);
        }
        return $this->decodeBarCodeCollection($resultCollection, $barCodeCollection);
    }

    private function decodeBarCodeCollection(Collection $resultCollection, Collection $barCodeCollection)
    {
        $collectionEncoders = $barCodeCollection->first()->getCollectionEncoders();
        $resultEncoder = $this->classEncoder->encodersToClasses($collectionEncoders);
        return $resultEncoder->decode($resultCollection->toArray());
    }

    private function arrayToCollection($array): Collection
    {
        $collection = new Collection();
        $wrapper = new XmlWrapper();
        foreach ($array as $item) {
            $barCodeEntity = $wrapper->decode($item);
            $collection->add($barCodeEntity);
        }
        $arr = EntityHelper::indexingCollection($collection, 'id');
        ksort($arr);
        return new Collection($arr);
    }

    private function decodeCollection($arr)
    {

    }
}