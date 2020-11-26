<?php

namespace ZnSandbox\Sandbox\Qr\Encoders;

use ZnCrypt\Base\Domain\Libs\Encoders\EncoderInterface;

class ImplodeEncoder implements EncoderInterface
{

    private $maxLenght = 650;

    public function encode($data)
    {
        $chunks = str_split($data, $this->maxLenght);
        return $chunks;
    }

    public function decode($encodedData)
    {
        return implode('', $encodedData);
    }
}