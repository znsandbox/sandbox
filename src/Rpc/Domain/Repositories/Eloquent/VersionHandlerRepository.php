<?php

namespace ZnLib\Rpc\Domain\Repositories\Eloquent;

use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnLib\Rpc\Domain\Entities\VersionHandlerEntity;
use ZnLib\Rpc\Domain\Interfaces\Repositories\VersionHandlerRepositoryInterface;

class VersionHandlerRepository extends \ZnLib\Rpc\Domain\Repositories\Eloquent\VersionHandlerRepository //BaseEloquentCrudRepository implements VersionHandlerRepositoryInterface
{

    /*public function tableName() : string
    {
        return 'security_version_handler';
    }

    public function getEntityClass() : string
    {
        return VersionHandlerEntity::class;
    }*/


}

