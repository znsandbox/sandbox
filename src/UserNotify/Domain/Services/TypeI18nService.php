<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeI18nRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TypeI18nServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;

class TypeI18nService extends BaseCrudService implements TypeI18nServiceInterface
{

    public function __construct(TypeI18nRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }


}

