<?php

namespace ZnSandbox\Sandbox\Person\Domain\Services;

use ZnSandbox\Sandbox\Person\Domain\Interfaces\Services\InheritanceServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Person\Domain\Interfaces\Repositories\InheritanceRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Person\Domain\Entities\InheritanceEntity;

/**
 * @method
 * InheritanceRepositoryInterface getRepository()
 */
class InheritanceService extends BaseCrudService implements InheritanceServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return InheritanceEntity::class;
    }


}

