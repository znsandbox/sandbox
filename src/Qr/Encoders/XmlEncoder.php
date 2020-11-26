<?php

namespace ZnSandbox\Sandbox\Qr\Encoders;

use ZnCrypt\Base\Domain\Libs\Encoders\EncoderInterface;
use ZnLib\Egov\Helpers\XmlHelper;

class XmlEncoder implements EncoderInterface
{

    public function encode($data)
    {

    }

    public function decode($encodedData)
    {
        return XmlHelper::decode($encodedData);
    }
}