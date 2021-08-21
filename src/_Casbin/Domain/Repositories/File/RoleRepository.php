<?php

namespace ZnUser\Rbac\Domain\Repositories\File;

use ZnUser\Rbac\Domain\Entities\RoleEntity;
use ZnUser\Rbac\Domain\Interfaces\Repositories\RoleRepositoryInterface;
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
