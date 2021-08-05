<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Geo\Domain\Entities\CurrencyEntity;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Repositories\CurrencyRepositoryInterface;

class CurrencyRepository extends BaseEloquentCrudRepository implements CurrencyRepositoryInterface
{

    public function tableName() : string
    {
        return 'geo_currency';
    }

    public function getEntityClass() : string
    {
        return CurrencyEntity::class;
    }


}

