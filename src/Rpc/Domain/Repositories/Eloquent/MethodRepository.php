<?php

namespace ZnLib\Rpc\Domain\Repositories\Eloquent;

use ZnCore\Domain\Libs\Query;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnLib\Rpc\Domain\Entities\MethodEntity;
use ZnLib\Rpc\Domain\Interfaces\Repositories\MethodRepositoryInterface;

class MethodRepository extends \ZnLib\Rpc\Domain\Repositories\Eloquent\MethodRepository  //BaseEloquentCrudRepository implements MethodRepositoryInterface
{

    /*public function tableName() : string
    {
        return 'rpc_route';
    }

    public function getEntityClass() : string
    {
        return MethodEntity::class;
    }

    public function oneByMethodName(string $method, int $version): MethodEntity
    {
        $query = new Query();
        $query->where('version', $version);
        $query->where('method_name', $method);
        return $this->one($query);
    }*/
}

