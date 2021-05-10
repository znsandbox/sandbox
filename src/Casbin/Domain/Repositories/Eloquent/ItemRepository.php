<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\ItemEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\ItemRepositoryInterface;

class ItemRepository extends BaseEloquentCrudRepository implements ItemRepositoryInterface
{

    public function tableName() : string
    {
        return 'rbac_item';
    }

    public function getEntityClass() : string
    {
        return ItemEntity::class;
    }


}

