<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Services;

use ZnSandbox\Sandbox\Eav\Domain\Entities\DynamicEntity;
use ZnSandbox\Sandbox\Eav\Domain\Entities\EntityEntity;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\EntityRepositoryInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Helpers\ValidationHelper;
use ZnCore\Domain\Libs\Query;

class EntityService extends BaseCrudService implements EntityServiceInterface
{

    private $attributeRepository;

    public function __construct(EntityRepositoryInterface $repository, AttributeRepositoryInterface $attributeRepository)
    {
        $this->repository = $repository;
        $this->attributeRepository = $attributeRepository;
    }

    public function oneByIdWithRelations($id, Query $query = null): EntityEntity
    {
        $query = Query::forge($query);
        $query->with([
            'attributesTie.attribute',
            //'attributesTie.attribute.enums',
            //'attributesTie.attribute.unit',
        ]);
        /** @var EntityEntity $entity */
        $entity = parent::oneById($id, $query);
        return $entity;
    }

    public function createEntityById(int $id): DynamicEntity
    {
        $entityEntity = $this->oneByIdWithRelations($id);
        return new DynamicEntity($entityEntity);
    }

    public function validate(int $entityId, array $data): object
    {
        $entityEntity = $this->oneByIdWithRelations($entityId);
        $dynamicEntity = new DynamicEntity($entityEntity);
        //$dynamicEntity = $this->createEntityById($entityId);
        EntityHelper::setAttributes($dynamicEntity, $data);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($entityEntity->getAttributes() as $attributeEntity) {
            $value = $propertyAccessor->getValue($dynamicEntity, $attributeEntity->getName());
            if($attributeEntity->getDefault() !== null && $value === null) {
                $propertyAccessor->setValue($dynamicEntity, $attributeEntity->getName(), $attributeEntity->getDefault());
            }
        }
        ValidationHelper::validateEntity($dynamicEntity);
        return $dynamicEntity;
    }
}
