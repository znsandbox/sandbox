<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Entities;

use ZnSandbox\Sandbox\Casbin\Domain\Enums\ItemTypeEnum;

class PermissionEntity extends ItemEntity
{

    protected $type = ItemTypeEnum::PERMISSION;
    
    public function setType($value): void
    {
        
    }
}
