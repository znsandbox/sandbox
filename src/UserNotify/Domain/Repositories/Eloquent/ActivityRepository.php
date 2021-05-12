<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\ActivityEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\ActivityRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class ActivityRepository extends BaseEloquentCrudRepository implements ActivityRepositoryInterface
{

    public function tableName(): string
    {
        return 'notify_activity';
    }

    public function getEntityClass(): string
    {
        return ActivityEntity::class;
    }
}
