<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Eav\Domain\Entities\ValidationEntity;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\ValidationRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnCore\Domain\Libs\Query;

class ValidationRepository extends BaseEloquentCrudRepository implements ValidationRepositoryInterface
{

    public function tableName() : string
    {
        return 'eav_validation';
    }

    public function getEntityClass() : string
    {
        return ValidationEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        return parent::forgeQuery($query)->orderBy(['sort' => SORT_ASC]);
    }
}

