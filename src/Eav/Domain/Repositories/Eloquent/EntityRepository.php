<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnSandbox\Sandbox\Eav\Domain\Entities\EntityAttributeEntity;
use ZnSandbox\Sandbox\Eav\Domain\Entities\EntityEntity;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\EntityAttributeRepositoryInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\EntityRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnCore\Domain\Relations\relations\OneToManyRelation;

class EntityRepository extends BaseEloquentCrudRepository implements EntityRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_entity';
    }

    public function getEntityClass(): string
    {
        return EntityEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToManyRelation::class,
                'relationAttribute' => 'id',
                'name' => 'attributesTie',
                'relationEntityAttribute' => 'attributes',
                'foreignRepositoryClass' => EntityAttributeRepositoryInterface::class,
                'foreignAttribute' => 'entity_id',
                'prepareCollection' => function (Collection $collection) {
                    /** @var EntityEntity $entityEntity */
                    foreach ($collection as $entityEntity) {
                        $entityAttributeCollection = $entityEntity->getAttributes();
                        $filedCollection = new Collection;
                        /** @var EntityAttributeEntity $entityAttributeEntity */
                        foreach ($entityAttributeCollection as $entityAttributeEntity) {
                            $attributeEntity = $entityAttributeEntity->getAttribute();
                            if($entityAttributeEntity->getDefault() !== null) {
                                $attributeEntity->setDefault($entityAttributeEntity->getDefault());
                            }
                            if($entityAttributeEntity->getIsRequired() !== null) {
                                $attributeEntity->setIsRequired($entityAttributeEntity->getIsRequired());
                            }
                            $filedCollection->add($attributeEntity);
                        }
                        $entityEntity->setAttributes($filedCollection);
                    }
                    return $collection;
                }
            ],
        ];
    }
}
