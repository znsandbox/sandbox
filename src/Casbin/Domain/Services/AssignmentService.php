<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Services;

use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\AssignmentServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\AssignmentRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\AssignmentEntity;

/**
 * @method
 * AssignmentRepositoryInterface getRepository()
 */
class AssignmentService extends BaseCrudService implements AssignmentServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return AssignmentEntity::class;
    }


}

