<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnLib\Db\Mappers\JsonMapper;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;

class QueueRepository extends BaseEloquentCrudRepository
{

    public function tableName(): string
    {
        return 'grabber_queue';
    }

    public function getEntityClass(): string
    {
        return QueueEntity::class;
    }

    public function mappers(): array
    {
        return [
            new JsonMapper(['query']),
        ];
    }
}
