<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\UserSecurity\Domain\Entities\VersionHandlerEntity;
use ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Repositories\VersionHandlerRepositoryInterface;

class VersionHandlerRepository extends BaseEloquentCrudRepository implements VersionHandlerRepositoryInterface
{

    public function tableName() : string
    {
        return 'security_version_handler';
    }

    public function getEntityClass() : string
    {
        return VersionHandlerEntity::class;
    }


}

