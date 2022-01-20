<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use ZnCore\Domain\Base\BaseService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\QueueRepositoryInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;

class QueueService extends BaseService implements QueueServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return QueueEntity::class;
    }

    public function add(string $url)
    {
        dd($url);
    }
}
