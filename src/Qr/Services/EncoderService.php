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
use ZnCrypt\Base\Domain\Libs\Encoders\EncoderInterface;
use ZnCrypt\Pki\X509\Domain\Helpers\QrDecoderHelper;
use ZnLib\Egov\Helpers\XmlHelper;
use ZnSandbox\Sandbox\Qr\Encoders\ImplodeEncoder;
use ZnSandbox\Sandbox\Qr\Encoders\SplitEncoder;
use ZnSandbox\Sandbox\Qr\Encoders\XmlEncoder;
use ZnSandbox\Sandbox\Qr\Entities\BarCodeEntity;
use ZnSandbox\Sandbox\Qr\Libs\ClassEncoder;
//use ZnSandbox\Sandbox\Qr\Libs\XmlWrapper;
use ZnSandbox\Sandbox\Qr\Encoders\ZipEncoder;
use ZnSandbox\Sandbox\Qr\Wrappers\JsonWrapper;
use ZnSandbox\Sandbox\Qr\Wrappers\WrapperInterface;
use ZnSandbox\Sandbox\Qr\Wrappers\XmlWrapper;
use Zxing\QrReader;

class EncoderService
{

    private $classEncoder;
    private $entityWrapper;

    public function __construct(ClassEncoder $classEncoder, /*EncoderInterface*/ $entityWrapper)
    {
        $this->classEncoder = $classEncoder;
        $this->entityWrapper = $entityWrapper;
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
        //$wrapper = new XmlWrapper();
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
            $collection->add($this->entityWrapper->encode($barCodeEntity));
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
        //$wrapper = $this->entityWrapper;
        foreach ($array as $item) {
            $wrapper = $this->detectWrapper($item);
            $barCodeEntity = $wrapper->decode($item);
            $collection->add($barCodeEntity);
        }
        $arr = EntityHelper::indexingCollection($collection, 'id');
        ksort($arr);
        return new Collection($arr);
    }

    private function detectWrapper(string $encoded): WrapperInterface
    {
        $wrappers = [
            JsonWrapper::class,
            XmlWrapper::class,
        ];
        foreach ($wrappers as $wrapperClass) {
            /** @var WrapperInterface $wrapperInstance */
            $wrapperInstance = new $wrapperClass;
            $isDetected = $wrapperInstance->isMatch($encoded);
            if($isDetected) {
                return $wrapperInstance;
            }
        }
        throw new \Exception('Wrapper not detected!');
    }

    private function decodeCollection($arr)
    {

    }
}