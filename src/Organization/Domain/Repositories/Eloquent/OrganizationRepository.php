<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Repositories\LocalityRepositoryInterface;
use ZnCore\Base\Libs\I18Next\Mappers\I18nMapper;
use ZnCore\Contract\Mapper\Interfaces\MapperInterface;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Organization\Domain\Entities\OrganizationEntity;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\OrganizationRepositoryInterface;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\TypeRepositoryInterface;

class OrganizationRepository extends BaseEloquentCrudRepository implements OrganizationRepositoryInterface
{

    public function tableName(): string
    {
        return 'organization_organization';
    }

    public function getEntityClass(): string
    {
        return OrganizationEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'type_id',
                'relationEntityAttribute' => 'type',
                'foreignRepositoryClass' => TypeRepositoryInterface::class,
            ],
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'city_id',
                'relationEntityAttribute' => 'locality',
                'foreignRepositoryClass' => LocalityRepositoryInterface::class,
            ]
        ];
    }

    public function mapper(): MapperInterface
    {
        return new I18nMapper($this->getEntityClass(), ['title_i18n']);
    }
}

