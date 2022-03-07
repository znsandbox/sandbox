<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Repositories\Eloquent;

use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Organization\Domain\Entities\UserEntity;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository extends BaseEloquentCrudRepository implements UserRepositoryInterface
{

    public function tableName() : string
    {
        return 'organization_user';
    }

    public function getEntityClass() : string
    {
        return UserEntity::class;
    }


}

