<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services;

use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeEntity;

interface TypeServiceInterface extends CrudServiceInterface
{

    public function oneByIdWithI18n(int $id): TypeEntity;
    public function oneByName(string $name): TypeEntity;
}

