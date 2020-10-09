<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Services;

use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Services\MeasureServiceInterface;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\MeasureRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;

class MeasureService extends BaseCrudService implements MeasureServiceInterface
{

    public function __construct(MeasureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

}
