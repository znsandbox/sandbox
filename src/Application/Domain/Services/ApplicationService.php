<?php

namespace ZnSandbox\Sandbox\Application\Domain\Services;

use ZnSandbox\Sandbox\Application\Domain\Interfaces\Services\ApplicationServiceInterface;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnSandbox\Sandbox\Application\Domain\Interfaces\Repositories\ApplicationRepositoryInterface;
use ZnCore\Base\Libs\Service\Base\BaseCrudService;
use ZnSandbox\Sandbox\Application\Domain\Entities\ApplicationEntity;

/**
 * @method
 * ApplicationRepositoryInterface getRepository()
 */
class ApplicationService extends BaseCrudService implements ApplicationServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return ApplicationEntity::class;
    }


}

