<?php

namespace ZnSandbox\Sandbox\Qr\Libs;

use Illuminate\Support\Collection;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCrypt\Base\Domain\Libs\Encoders\Base64Encoder;
use ZnSandbox\Sandbox\Qr\Encoders\ImplodeEncoder;
use ZnSandbox\Sandbox\Qr\Encoders\XmlEncoder;
use ZnSandbox\Sandbox\Qr\Encoders\ZipEncoder;

class ClassEncoder
{

    private $assoc = [];

    public function __construct(array $assoc)
    {
        $this->assoc = $assoc;
    }

    private function encoderToClass(string $name)
    {
        return ArrayHelper::getValue($this->assoc, $name);
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