<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\PageServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\PageRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\PageEntity;

/**
 * @method
 * PageRepositoryInterface getRepository()
 */
class PageService extends BaseCrudService implements PageServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return PageEntity::class;
    }


}

