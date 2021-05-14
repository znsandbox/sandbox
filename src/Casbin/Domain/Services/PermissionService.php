<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Services;

use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\PermissionServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\PermissionRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\PermissionEntity;

/**
 * @method PermissionRepositoryInterface getRepository()
 */
class PermissionService extends BaseCrudService implements PermissionServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return PermissionEntity::class;
    }


}

