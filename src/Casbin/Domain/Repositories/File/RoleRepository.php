<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\File;

use ZnSandbox\Sandbox\Casbin\Domain\Entities\RoleEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\RoleRepositoryInterface;
use ZnCore\Domain\Base\Repositories\BaseFileCrudRepository;

class RoleRepository extends BaseFileCrudRepository implements RoleRepositoryInterface
{

    public function getEntityClass(): string
    {
        return RoleEntity::class;
    }

    public function fileName(): string
    {
        return __DIR__ . '/../../../../../../config/rbac_role.php';
    }
}
