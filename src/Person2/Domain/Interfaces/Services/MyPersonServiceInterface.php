<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services;

use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;

interface MyPersonServiceInterface
{

    public function update(array $data): void;

    public function one(): PersonEntity;
}
