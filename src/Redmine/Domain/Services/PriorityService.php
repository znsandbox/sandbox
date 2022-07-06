<?php

namespace ZnSandbox\Sandbox\Redmine\Domain\Services;

use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Services\PriorityServiceInterface;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;
use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Repositories\PriorityRepositoryInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\PriorityEntity;

/**
 * @method PriorityRepositoryInterface getRepository()
 */
class PriorityService extends BaseCrudService implements PriorityServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return PriorityEntity::class;
    }


}

