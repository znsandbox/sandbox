<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Services;

use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\EnumServiceInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\EnumRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class EnumService extends BaseCrudService implements EnumServiceInterface
{

    public function __construct(EnumRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}

