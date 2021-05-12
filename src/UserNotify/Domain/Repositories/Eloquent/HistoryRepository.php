<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\HistoryRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class HistoryRepository extends BaseEloquentCrudRepository implements HistoryRepositoryInterface
{

    public function tableName(): string
    {
        return 'notify_history';
    }

    public function getEntityClass(): string
    {
        return NotifyEntity::class;
    }

    /*public function send(NotifyEntity $notifyEntity) {
        ValidationHelper::validateEntity($notifyEntity);

    }*/
}
