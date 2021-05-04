<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\InheritanceRepositoryInterface;

class InheritanceRepository extends BaseEloquentCrudRepository implements InheritanceRepositoryInterface
{

    public function tableName() : string
    {
        return 'rbac_inheritance';
    }

    public function getEntityClass() : string
    {
        return InheritanceEntity::class;
    }


}

