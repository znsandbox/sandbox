<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TypeTransportServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeTransportEntity;

class TypeTransportService extends BaseCrudService implements TypeTransportServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return TypeTransportEntity::class;
    }


}

