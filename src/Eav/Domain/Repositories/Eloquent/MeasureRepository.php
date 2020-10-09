<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Eav\Domain\Entities\MeasureEntity;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\MeasureRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class MeasureRepository extends BaseEloquentCrudRepository implements MeasureRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_measure';
    }

    public function getEntityClass(): string
    {
        return MeasureEntity::class;
    }

}
