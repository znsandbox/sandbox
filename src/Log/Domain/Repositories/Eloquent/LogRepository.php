<?php

namespace ZnSandbox\Sandbox\Log\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Helpers\ValidationHelper;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Log\Domain\Entities\LogEntity;
use ZnSandbox\Sandbox\Log\Domain\Interfaces\Repositories\LogRepositoryInterface;

class LogRepository extends BaseEloquentCrudRepository implements LogRepositoryInterface
{

    public function tableName(): string
    {
        return 'log_history';
    }

    public function getEntityClass(): string
    {
        return LogEntity::class;
    }

    public function createCollection(Collection $collection)
    {
        $array = [];
        foreach ($collection as $entity) {
            ValidationHelper::validateEntity($entity);
            $columnList = $this->getColumnsForModify();
            $array[] = EntityHelper::toArrayForTablize($entity, $columnList);
        }
        $this->getQueryBuilder()->insert($array);
    }
}
