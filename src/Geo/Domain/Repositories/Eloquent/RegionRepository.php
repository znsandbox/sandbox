<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Repositories\CountryRepositoryInterface;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Repositories\LocalityRepositoryInterface;
use ZnCore\Base\Libs\I18Next\Mappers\I18nMapper;
use ZnCore\Contract\Mapper\Interfaces\MapperInterface;
use ZnCore\Domain\Relations\relations\OneToManyRelation;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Geo\Domain\Entities\RegionEntity;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Repositories\RegionRepositoryInterface;

class RegionRepository extends BaseEloquentCrudRepository implements RegionRepositoryInterface
{

    public function tableName() : string
    {
        return 'geo_region';
    }

    public function getEntityClass() : string
    {
        return RegionEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'country_id',
                'relationEntityAttribute' => 'country',
                'foreignRepositoryClass' => CountryRepositoryInterface::class,
            ],
            [
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'relationEntityAttribute' => 'localities',
                'foreignRepositoryClass' => LocalityRepositoryInterface::class,
                'foreignAttribute' => 'region_id',
            ]
        ];
    }

    public function mapper(): MapperInterface
    {
        return new I18nMapper($this->getEntityClass(), ['name_i18n']);
    }

}

