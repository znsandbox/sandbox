<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TransportEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TransportRepositoryInterface;

class TransportRepository extends BaseEloquentCrudRepository implements TransportRepositoryInterface
{

    public function tableName() : string
    {
        return 'notify_transport';
    }

    public function getEntityClass() : string
    {
        return TransportEntity::class;
    }


}

