<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Repositories\Eloquent;

use ZnBundle\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnCore\Base\Libs\Relation\Libs\Types\OneToOneRelation;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Person2\Domain\Entities\ContactEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\ContactRepositoryInterface;

class ContactRepository extends BaseEloquentCrudRepository implements ContactRepositoryInterface
{

    public function tableName() : string
    {
        return 'person_contact';
    }

    public function getEntityClass() : string
    {
        return ContactEntity::class;
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
