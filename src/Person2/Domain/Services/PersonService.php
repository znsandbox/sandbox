<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\PersonRepositoryInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;

/**
 * @method PersonRepositoryInterface getRepository()
 */
class PersonService extends BaseCrudService implements PersonServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return PersonEntity::class;
    }

    public function persist(object $entity)
    {
        try {
            $uniqueEntity = $this->getEntityManager()->oneByUnique($entity);
            EntityHelper::setAttributesFromObject($uniqueEntity, $entity);
        } catch (NotFoundException $e) {}
        parent::persist($entity);
    }
}
