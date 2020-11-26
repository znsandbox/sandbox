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

    public function encode($entity)
    {

    }

    public function decode($encodedData)
    {
        $barCodeCollection = $this->arrayToCollection($encodedData);

        $resultCollection = new Collection();
        foreach ($barCodeCollection as $barCodeEntity) {
            $entityEncoders = $this->encodersToClasses($barCodeEntity->getEntityEncoders());
            $decodedItem = $entityEncoders->decode($barCodeEntity->getData());
            $resultCollection->add($decodedItem);
        }

        return $this->decodeBarCodeCollection($resultCollection, $barCodeCollection);
    }

    private function encodersToClasses(array $names): CollectionEncoder
    {
        $enc = new ClassEncoder();
        return $enc->encodersToClasses($names);
    }

    private function decodeBarCodeCollection(Collection $resultCollection, Collection $barCodeCollection)
    {
        $collectionEncoders = $barCodeCollection->first()->getCollectionEncoders();
        $resultEncoder = $this->encodersToClasses($collectionEncoders);
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