<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\File;

use ZnCore\Domain\Base\Repositories\BaseFileCrudRepository;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\InheritanceRepositoryInterface;

class InheritanceRepository extends BaseFileCrudRepository implements InheritanceRepositoryInterface
{

    private $fileName = __DIR__ . '/../../../../../../../../config/rbac_inheritance.php';
    
    public function getEntityClass(): string
    {
        return InheritanceEntity::class;
    }

    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function fileName(): string
    {
        return $this->fileName;
    }
}
