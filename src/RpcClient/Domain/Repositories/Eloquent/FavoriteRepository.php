<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Repositories\FavoriteRepositoryInterface;

class FavoriteRepository extends BaseEloquentCrudRepository implements FavoriteRepositoryInterface
{

    public function tableName() : string
    {
        return 'rpc_client_favorite';
    }

    public function getEntityClass() : string
    {
        return FavoriteEntity::class;
    }
}
