<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Eav\Domain\Entities\AttributeEntity;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\EnumRepositoryInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\ValidationRepositoryInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\MeasureRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Relations\relations\OneToManyRelation;
use ZnCore\Domain\Relations\relations\OneToOneRelation;

class AttributeRepository extends BaseEloquentCrudRepository implements AttributeRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_attribute';
    }

    public function getEntityClass(): string
    {
        return AttributeEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'relationEntityAttribute' => 'rules',
                'foreignRepositoryClass' => ValidationRepositoryInterface::class,
                'foreignAttribute' => 'attribute_id',
            ],
            [
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'relationEntityAttribute' => 'enums',
                'foreignRepositoryClass' => EnumRepositoryInterface::class,
                'foreignAttribute' => 'attribute_id',
            ],
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'unit_id',
                'relationEntityAttribute' => 'unit',
                'foreignRepositoryClass' => MeasureRepositoryInterface::class,
            ],
        ];
    }

    protected function forgeQuery(Query $query = null)
    {
        return parent::forgeQuery($query)
            ->with(['rules', 'enums', 'unit']);
    }
}
