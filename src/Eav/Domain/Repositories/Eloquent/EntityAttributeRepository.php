<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Eav\Domain\Entities\EntityAttributeEntity;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\EntityAttributeRepositoryInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Relations\relations\OneToOneRelation;

class EntityAttributeRepository extends BaseEloquentCrudRepository implements EntityAttributeRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_entity_attribute';
    }

    public function getEntityClass(): string
    {
        return EntityAttributeEntity::class;
    }

    protected function forgeQuery(Query $query = null)
    {
        return parent::forgeQuery($query)->orderBy(['sort' => SORT_ASC]);
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'attribute_id',
                'relationEntityAttribute' => 'attribute',
                'foreignRepositoryClass' => AttributeRepositoryInterface::class,
            ],
        ];
    }
}

