<?php

namespace ZnSandbox\Sandbox\Status\Domain\Services;

use ZnSandbox\Sandbox\Status\Domain\Interfaces\Repositories\StatusRepositoryInterface;
use ZnSandbox\Sandbox\Status\Domain\Interfaces\Services\StatusServiceInterface;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Domain\Base\BaseCrudService;

DeprecateHelper::hardThrow();

class StatusService extends BaseCrudService implements StatusServiceInterface
{

    public function __construct(StatusRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }
}
