<?php

namespace ZnSandbox\Sandbox\Qr\Libs;

use Illuminate\Support\Collection;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCrypt\Base\Domain\Libs\Encoders\Base64Encoder;
use ZnCrypt\Base\Domain\Libs\Encoders\CollectionEncoder;
use ZnSandbox\Sandbox\Qr\Encoders\ImplodeEncoder;
use ZnSandbox\Sandbox\Qr\Encoders\XmlEncoder;
use ZnSandbox\Sandbox\Qr\Encoders\ZipEncoder;

class ClassEncoder
{

    public function encoderToClass(string $name): string
    {
        $assoc = [
            'xml' => XmlEncoder::class,
            'zip' => ZipEncoder::class,
            'implode' => ImplodeEncoder::class,
            'base64' => Base64Encoder::class,
        ];
        return ArrayHelper::getValue($assoc, $name);
    }

    public function encodersToClasses(array $names): CollectionEncoder
    {
        $classes = [];
        foreach ($names as $name) {
            $classes[] = $this->encoderToClass($name);
        }
        $encoders = new CollectionEncoder(new Collection($classes));
        return $encoders;
    }

}