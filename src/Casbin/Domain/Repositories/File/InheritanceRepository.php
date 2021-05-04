<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\File;

use ZnSandbox\Sandbox\Casbin\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\InheritanceRepositoryInterface;
use ZnCore\Domain\Base\Repositories\BaseFileCrudRepository;

class InheritanceRepository extends BaseFileCrudRepository implements InheritanceRepositoryInterface
{

    public function getEntityClass(): string
    {
        return InheritanceEntity::class;
    }

    public function fileName(): string
    {
        return __DIR__ . '/../../../../../../config/rbac_inheritance.php';
    }
}
