<?php

namespace ZnSandbox\Sandbox\Qr\Encoders;

use ZnCrypt\Base\Domain\Libs\Encoders\EncoderInterface;

class ImplodeEncoder implements EncoderInterface
{

    private $maxLenght;

    public function __construct(int $maxLenght)
    {
        $this->maxLenght = $maxLenght;
    }

    public function encode($data)
    {
        return str_split($data, $this->maxLenght);
    }

    public function decode($encodedData)
    {
        return implode('', $encodedData);
    }
}