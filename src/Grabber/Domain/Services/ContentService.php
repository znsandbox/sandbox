<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\ContentServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\ContentRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\ContentEntity;

/**
 * @method ContentRepositoryInterface getRepository()
 */
class ContentService extends BaseCrudService implements ContentServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return ContentEntity::class;
    }


}

