<?php

namespace ZnSandbox\Sandbox\Redmine\Domain\Services;

use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;
use ZnSandbox\Sandbox\Redmine\Domain\Interfaces\Repositories\ProjectRepositoryInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\ProjectEntity;

/**
 * @method ProjectRepositoryInterface getRepository()
 */
class ProjectService extends BaseCrudService implements ProjectServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return ProjectEntity::class;
    }


}

