<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Services;

use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\TypeServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\TypeRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Organization\Domain\Entities\TypeEntity;

/**
 * @method
 * TypeRepositoryInterface getRepository()
 */
class TypeService extends BaseCrudService implements TypeServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return TypeEntity::class;
    }


}

