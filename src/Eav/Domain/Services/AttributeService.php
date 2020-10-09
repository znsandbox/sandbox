<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Services;

use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\AttributeServiceInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\AttributeRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class AttributeService extends BaseCrudService implements AttributeServiceInterface
{

    public function __construct(AttributeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

