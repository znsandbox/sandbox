<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\SiteServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\SiteRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\SiteEntity;

/**
 * @method
 * SiteRepositoryInterface getRepository()
 */
class SiteService extends BaseCrudService implements SiteServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return SiteEntity::class;
    }


}
