<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\RoleEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\RoleRepositoryInterface;

class RoleRepository extends BaseEloquentCrudRepository implements RoleRepositoryInterface
{

    public function tableName() : string
    {
        return 'rbac_role';
    }

    public function getEntityClass() : string
    {
        return RoleEntity::class;
    }


}

