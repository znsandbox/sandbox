<?php

namespace ZnSandbox\Sandbox\Contact\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Contact\Domain\Entities\ValueEntity;
use ZnSandbox\Sandbox\Contact\Domain\Interfaces\Repositories\ValueRepositoryInterface;
use ZnBundle\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnCore\Domain\Relation\Libs\Types\OneToOneRelation;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;

class ValueRepository extends BaseEloquentCrudRepository implements ValueRepositoryInterface
{

    public function tableName(): string
    {
        return 'contact_value';
    }

    public function getEntityClass(): string
    {
        return ValueEntity::class;
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
