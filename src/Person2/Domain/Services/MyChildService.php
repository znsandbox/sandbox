<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use phpDocumentor\Reflection\Types\This;
use ZnCore\Base\Exceptions\DeprecatedException;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Enums\EventEnum;
use ZnCore\Domain\Events\EntityEvent;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyChildServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnSandbox\Sandbox\Person2\Domain\Subscribers\MyChildBehavior;

class MyChildService extends BaseCrudService implements MyChildServiceInterface
{

    private $myPersonService;
    private $personService;

    public function __construct(
        EntityManagerInterface $em,
        MyPersonServiceInterface $myPersonService,
        PersonServiceInterface $personService
    )
    {
        $this->setEntityManager($em);
        $this->myPersonService = $myPersonService;
        $this->personService = $personService;
    }

    public function getEntityClass(): string
    {
        return InheritanceEntity::class;
    }

    public function subscribes(): array
    {
        return [
            MyChildBehavior::class,
        ];
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = parent::forgeQuery($query);
        $myPersonId = $this->myPersonService->one()->getId();
        $query->where('parent_person_id', $myPersonId);
        return $query;
    }

    public function deleteById($id)
    {
        $this->oneById($id);
        parent::deleteById($id);
    }

    public function updateById($id, $data)
    {
        $childEntity = $this->personService->oneById($id);

        $event = new EntityEvent($childEntity);
        $this->getEventDispatcher()->dispatch($event, EventEnum::BEFORE_UPDATE_ENTITY);

        EntityHelper::setAttributes($childEntity, $data);
        $this->getEntityManager()->persist($childEntity);

        $event = new EntityEvent($childEntity);
        $this->getEventDispatcher()->dispatch($event, EventEnum::AFTER_UPDATE_ENTITY);
    }

    public function persistData(array $params)
    {
        $personEntity = EntityHelper::createEntity(PersonEntity::class, $params);
        $this->getEntityManager()->persist($personEntity);

        $parentPersonEntity = $this->myPersonService->one();

        /** @var InheritanceEntity $inheritanceEntity */
        $inheritanceEntity = $this->createEntity($params);
        $inheritanceEntity->setParentPersonId($parentPersonEntity->getId());
        $inheritanceEntity->setChildPersonId($personEntity->getId());
        $inheritanceEntity->setParentPerson($parentPersonEntity);
        $inheritanceEntity->setChildPerson($personEntity);

        $this->persist($inheritanceEntity);

        return $inheritanceEntity;
    }

    public function create($data): EntityIdInterface
    {
        $myPersonId = $this->myPersonService->one()->getId();
        $childEntity = $this->personService->create($data);
        $data['parent_person_id'] = $myPersonId;
        $data['child_person_id'] = $childEntity->getId();
        return parent::create($data);
    }
}
