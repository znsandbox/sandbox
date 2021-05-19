<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Entities;

use ZnSandbox\Sandbox\Casbin\Domain\Enums\ItemTypeEnum;

class RoleEntity extends ItemEntity
{

    protected $type = ItemTypeEnum::ROLE;
    
    public function setType($value): void
    {

    }
}
