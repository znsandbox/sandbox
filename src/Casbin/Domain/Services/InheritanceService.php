<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Services;

use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\InheritanceServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\InheritanceEntity;

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

