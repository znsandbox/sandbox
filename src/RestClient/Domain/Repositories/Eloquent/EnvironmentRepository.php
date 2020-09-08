<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Repositories\Eloquent;

use ZnCore\Db\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\RestClient\Domain\Entities\EnvironmentEntity;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Repositories\EnvironmentRepositoryInterface;

class EnvironmentRepository extends BaseEloquentCrudRepository implements EnvironmentRepositoryInterface
{

    public function tableName() : string
    {
        return 'restclient_environment';
    }

    public function getEntityClass() : string
    {
        return EnvironmentEntity::class;
    }


}

