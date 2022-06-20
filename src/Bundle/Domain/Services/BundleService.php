<?php

namespace ZnSandbox\Sandbox\Bundle\Domain\Services;

use ZnSandbox\Sandbox\Bundle\Domain\Interfaces\Services\BundleServiceInterface;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnSandbox\Sandbox\Bundle\Domain\Interfaces\Repositories\BundleRepositoryInterface;
use ZnCore\Base\Libs\Service\Base\BaseCrudService;
use ZnSandbox\Sandbox\Bundle\Domain\Entities\BundleEntity;

/**
 * @method BundleRepositoryInterface getRepository()
 */
class BundleService extends BaseCrudService implements BundleServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return BundleEntity::class;
    }


}

