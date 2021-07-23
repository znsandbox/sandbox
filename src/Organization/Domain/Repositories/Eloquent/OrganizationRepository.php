<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Repositories\Eloquent;

use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnLib\Db\Mappers\JsonMapper;
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
        ];
    }

    public function mappers(): array
    {
        return [
            new JsonMapper(['title_i18n']),
        ];
    }
}
