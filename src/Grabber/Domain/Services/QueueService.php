<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\PageEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\SiteEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Helpers\UrlHelper;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\QueueRepositoryInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;

/**
 * @method QueueRepositoryInterface getRepository()
 */
class QueueService extends BaseCrudService implements QueueServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return QueueEntity::class;
    }

    public function addLink(string $url, string $type) {
        $queueEntity = $this->createEntityByUrl($url);
        $queueEntity->setType($type);
        $this->getEntityManager()->persist($queueEntity);
        //dd($queueEntity);
    }

    private function createEntityByUrl(string $url): QueueEntity
    {
        $urlArr = UrlHelper::parse($url);

        $siteEntity = new SiteEntity();
        $siteEntity->setHost($urlArr['host']);
        $this->getEntityManager()->persist($siteEntity);

        $queueEntity = new QueueEntity();
        $queueEntity->setSiteId($siteEntity->getId());
        $queueEntity->setPath($urlArr['path']);
        $queueEntity->setQuery($urlArr['queryParams']);
        return $queueEntity;
    }
}
