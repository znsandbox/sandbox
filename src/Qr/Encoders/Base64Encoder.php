<?php

namespace ZnSandbox\Sandbox\Qr\Encoders;

use ZnCrypt\Base\Domain\Libs\Encoders\EncoderInterface;

class Base64Encoder implements EncoderInterface
{

    public function encode($data)
    {
        dd($data);
        return base64_encode($data);
    }

    public function decode($encodedData)
    {
        return base64_decode($encodedData);
    }
}