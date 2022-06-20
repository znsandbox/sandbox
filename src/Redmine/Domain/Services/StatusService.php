<?php

namespace ZnSandbox\Sandbox\Redmine\Domain\Services;

use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Services\StatusServiceInterface;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Repositories\StatusRepositoryInterface;
use ZnCore\Base\Libs\Service\Base\BaseCrudService;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\StatusEntity;

/**
 * @method StatusRepositoryInterface getRepository()
 */
class StatusService extends BaseCrudService implements StatusServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return StatusEntity::class;
    }


}

