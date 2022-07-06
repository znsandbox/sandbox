<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use ZnCore\Entity\Interfaces\EntityIdInterface;
use ZnCore\Service\Base\BaseCrudService;
use ZnCore\Domain\Domain\Enums\EventEnum;
use ZnCore\Domain\Domain\Events\EntityEvent;
use ZnCore\Entity\Helpers\EntityHelper;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Query\Entities\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyChildServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Subscribers\MyChildSubscriber;

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
            MyChildSubscriber::class,
        ];
    }

    protected function forgeQuery(Query $query = null): Query
    {
        $query = parent::forgeQuery($query);
        $myPersonId = $this->myPersonService->findOne()->getId();
        $query->where('parent_person_id', $myPersonId);
        return $query;
    }

    public function deleteById($id)
    {
        $this->findOneById($id);
        parent::deleteById($id);
    }

    public function updateById($id, $data)
    {
        $childEntity = $this->personService->findOneById($id);

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

        $parentPersonEntity = $this->myPersonService->findOne();

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
        $myPersonId = $this->myPersonService->findOne()->getId();
        $childEntity = $this->personService->create($data);
        $data['parent_person_id'] = $myPersonId;
        $data['child_person_id'] = $childEntity->getId();
        return parent::create($data);
    }
}
