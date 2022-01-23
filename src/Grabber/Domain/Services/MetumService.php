<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\MetumServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\MetumRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\MetumEntity;

/**
 * @method MetumRepositoryInterface getRepository()
 */
class MetumService extends BaseCrudService implements MetumServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return MetumEntity::class;
    }


}

