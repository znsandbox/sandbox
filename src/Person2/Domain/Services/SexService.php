<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use ZnBundle\Reference\Domain\Entities\ItemEntity;
use ZnCore\Service\Base\BaseCrudService;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;
use ZnSandbox\Sandbox\Person2\Domain\Entities\SexEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\SexRepositoryInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\SexServiceInterface;

/**
 * @method SexRepositoryInterface getRepository()
 */
class SexService extends BaseCrudService implements SexServiceInterface
{

    public function __construct(EntityManagerInterface $em, SexRepositoryInterface $repository)
    {
        $this->setEntityManager($em);
        $this->setRepository($repository);
    }

    public function getEntityClass(): string
    {
        return ItemEntity::class;
    }
}
