<?php

namespace ZnUser\Rbac\Domain\Repositories\Eloquent;

use ZnCore\Domain\Libs\Query;
use ZnUser\Rbac\Domain\Entities\ItemEntity;
use ZnUser\Rbac\Domain\Entities\RoleEntity;
use ZnUser\Rbac\Domain\Enums\ItemTypeEnum;

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
