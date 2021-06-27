<?php

namespace ZnSandbox\Sandbox\Bundle\Domain\Services;

use ZnSandbox\Sandbox\Bundle\Domain\Interfaces\Services\DomainServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Bundle\Domain\Interfaces\Repositories\DomainRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\Bundle\Domain\Entities\DomainEntity;

/**
 * @method
 * DomainRepositoryInterface getRepository()
 */
class DomainService extends BaseCrudService implements DomainServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return DomainEntity::class;
    }


}

