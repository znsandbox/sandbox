<?php

namespace ZnSandbox\Sandbox\Qr\Wrappers;

use ZnSandbox\Sandbox\Qr\Entities\BarCodeEntity;

interface WrapperInterface
{

    public function isMatch(string $encodedData): bool;

    public function encode(BarCodeEntity $entity): string;

    public function decode(string $encodedData): BarCodeEntity;
}
