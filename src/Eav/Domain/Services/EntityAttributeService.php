<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Services;

use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\EntityAttributeServiceInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\EntityAttributeRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class EntityAttributeService extends BaseCrudService implements EntityAttributeServiceInterface
{

    public function __construct(EntityAttributeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

