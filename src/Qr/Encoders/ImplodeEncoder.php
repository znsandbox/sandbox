<?php

namespace ZnSandbox\Sandbox\Qr\Encoders;

use ZnCrypt\Base\Domain\Libs\Encoders\EncoderInterface;

class ImplodeEncoder implements EncoderInterface
{

    public function encode($data)
    {

    }

    public function decode($encodedData)
    {
        return implode('', $encodedData);
    }
}