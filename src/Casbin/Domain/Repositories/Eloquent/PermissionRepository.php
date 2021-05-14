<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\Eloquent;

use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\ItemEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\PermissionEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Enums\ItemTypeEnum;

class PermissionRepository extends ItemRepository
{

    public function getEntityClass(): string
    {
        return PermissionEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = parent::forgeQuery($query);
        $query->where('type', ItemTypeEnum::PERMISSION);
        return $query;
    }
}
