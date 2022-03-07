<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnDatabase\Base\Domain\Mappers\JsonMapper;
use ZnDatabase\Base\Domain\Mappers\TimeMapper;
use ZnSandbox\Sandbox\RpcClient\Domain\Entities\FavoriteEntity;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Repositories\FavoriteRepositoryInterface;
use ZnSandbox\Sandbox\RpcClient\Domain\Interfaces\Repositories\UserRepositoryInterface;

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

    public function mappers(): array
    {
        return [
            new JsonMapper([
                'body',
                'meta',
            ]),
            new TimeMapper(['createdAt', 'updatedAt']),
        ];
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'auth_by',
                'relationEntityAttribute' => 'auth',
                'foreignRepositoryClass' => UserRepositoryInterface::class
            ],
        ];
    }
}
