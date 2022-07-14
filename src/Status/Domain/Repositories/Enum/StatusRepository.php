<?php

namespace ZnSandbox\Sandbox\Status\Domain\Repositories\Enum;

use ZnSandbox\Sandbox\Status\Domain\Entities\EnumEntity;
use ZnSandbox\Sandbox\Status\Domain\Enums\StatusEnum;
use ZnSandbox\Sandbox\Status\Domain\Interfaces\Repositories\StatusRepositoryInterface;
use ZnDomain\Сomponents\EnumRepository\Base\BaseEnumCrudRepository;

class StatusRepository extends BaseEnumCrudRepository implements StatusRepositoryInterface
{

    private $enumClass = StatusEnum::class;

    public function enumClass(): string
    {
        return $this->enumClass;
    }

    public function getEntityClass(): string
    {
        return EnumEntity::class;
    }
}
