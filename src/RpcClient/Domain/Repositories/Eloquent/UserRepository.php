<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\UserEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository extends BaseEloquentCrudRepository implements UserRepositoryInterface
{

    public function tableName() : string
    {
        return 'rpc-client_user';
    }

    public function getEntityClass() : string
    {
        return UserEntity::class;
    }


}

