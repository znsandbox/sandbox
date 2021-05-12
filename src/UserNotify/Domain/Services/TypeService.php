<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TypeServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;

class TypeService extends BaseCrudService implements TypeServiceInterface
{

    public function __construct(TypeRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }
}
