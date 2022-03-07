<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Geo\Domain\Entities\CountryEntity;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Repositories\CountryRepositoryInterface;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Repositories\LocalityRepositoryInterface;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Repositories\RegionRepositoryInterface;
use ZnCore\Base\Libs\I18Next\Mappers\I18nMapper;
use ZnCore\Contract\Mapper\Interfaces\MapperInterface;
use ZnCore\Domain\Relations\relations\OneToManyRelation;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;

class CountryRepository extends BaseEloquentCrudRepository implements CountryRepositoryInterface
{

    public function tableName() : string
    {
        return 'geo_country';
    }

    public function getEntityClass() : string
    {
        return CountryEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'relationEntityAttribute' => 'regions',
                'foreignRepositoryClass' => RegionRepositoryInterface::class,
                'foreignAttribute' => 'country_id',
            ],
            [
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'relationEntityAttribute' => 'localities',
                'foreignRepositoryClass' => LocalityRepositoryInterface::class,
                'foreignAttribute' => 'country_id',
            ],
        ];
    }

    public function mapper(): MapperInterface
    {
        return new I18nMapper($this->getEntityClass(), ['name_i18n']);
    }

}

