<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use ZnBundle\Eav\Domain\Entities\EntityAttributeEntity;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityAttributeServiceInterface;
use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Domain\Query\Entities\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\ContactTypeEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\ContactTypeRepositoryInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\ContactTypeServiceInterface;

class ContactTypeService extends BaseCrudService implements ContactTypeServiceInterface
{

    private $entityAttributeService;
    private $entityId;

    public function __construct(
        EntityManagerInterface $em,
        EntityAttributeServiceInterface $entityAttributeService,
        EntityServiceInterface $eavEntityService
    )
    {
        $this->setEntityManager($em);
        $this->entityAttributeService = $entityAttributeService;

        $entity = $eavEntityService->oneByName('personContact');
        $this->entityId = $entity->getId();
    }

    public function getEntityClass(): string
    {
        return ContactTypeEntity::class;
    }

    public function all(Query $query = null): Enumerable
    {
        $query = new Query;
        $query->where('entity_id', $this->entityId);
        $query->with([
            'attribute',
        ]);
        $attributeCollection = $this->entityAttributeService->all($query);
        $collection = new Collection();
        /** @var EntityAttributeEntity $attributeTieEntity */
        foreach ($attributeCollection as $attributeTieEntity) {
            $collection->add($attributeTieEntity->getAttribute());
        }
        return $collection;
    }

    public function count(Query $query = null): int
    {
        $query = new Query;
        $query->where('entity_id', $this->entityId);
        return $this->entityAttributeService->count($query);
    }
}
