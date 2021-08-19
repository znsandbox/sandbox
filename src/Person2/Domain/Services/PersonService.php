<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Services;

use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\PersonRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;

/**
 * @method PersonRepositoryInterface getRepository()
 */
class PersonService extends BaseCrudService implements PersonServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return PersonEntity::class;
    }
}
