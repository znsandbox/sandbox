<?php

namespace ZnSandbox\Sandbox\Log\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Log\Domain\Entities\LogEntity;
use ZnSandbox\Sandbox\Log\Domain\Interfaces\Repositories\LogRepositoryInterface;

class LogRepository extends BaseEloquentCrudRepository implements LogRepositoryInterface
{

    public function tableName(): string
    {
        return 'eq_log';
    }

    public function getEntityClass(): string
    {
        return LogEntity::class;
    }
}
