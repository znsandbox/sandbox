<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Services;

use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\ValidationServiceInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\ValidationRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class ValidationService extends BaseCrudService implements ValidationServiceInterface
{

    public function __construct(ValidationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

