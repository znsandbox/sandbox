<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Eav\Domain\Entities\EnumEntity;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\EnumRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnCore\Domain\Libs\Query;

class EnumRepository extends BaseEloquentCrudRepository implements EnumRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_enum';
    }

    public function getEntityClass(): string
    {
        return EnumEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        return parent::forgeQuery($query)->orderBy(['sort' => SORT_ASC]);
    }
}

