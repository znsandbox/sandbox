<?php

namespace ZnSandbox\Sandbox\Application\Domain\Services;

use ZnSandbox\Sandbox\Application\Domain\Interfaces\Services\ApplicationServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Application\Domain\Interfaces\Repositories\ApplicationRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
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

