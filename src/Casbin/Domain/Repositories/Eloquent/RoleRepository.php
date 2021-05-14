<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\Eloquent;

use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\ItemEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\RoleEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Enums\ItemTypeEnum;

class RoleRepository extends ItemRepository
{

    public function getEntityClass(): string
    {
        return RoleEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = parent::forgeQuery($query);
        $query->where('type', ItemTypeEnum::ROLE);
        return $query;
    }
}
