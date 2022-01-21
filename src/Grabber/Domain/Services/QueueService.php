<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use Illuminate\Support\Collection;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\SiteEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\UrlEntity;
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

    public function addLink(string $url, string $type)
    {
        $queueEntity = $this->createEntityByUrl($url);
        $queueEntity->setType($type);
        $this->getEntityManager()->persist($queueEntity);
        //dd($queueEntity);
    }

    public function allNew(): Collection
    {
        return $this->getRepository()->allNew();
    }

    public function runAll()
    {
        $queueCollection = $this->getRepository()->allNew();
        foreach ($queueCollection as $queueEntity) {
            $this->runOne($queueEntity);
        }
//        dd($queueCollection);
    }

    public function runOne(QueueEntity $queueEntity)
    {
        $urlEntity = new UrlEntity();
        $urlEntity->setHost($queueEntity->getSite()->getHost());
        $urlEntity->setPath($queueEntity->getPath());
        $urlEntity->setQueryParams($queueEntity->getQuery());
        $urlEntity->setScheme('https');
        $url = $urlEntity->__toString();
//        dd($url);


        /*$browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', $url);
        $crawler->*/

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        if ($res->getStatusCode() !== 200) {
            throw new \Exception('Fail status code!');
        }

        $queueEntity->setContent($res->getBody()->getContents());
        $queueEntity->setStatusId(StatusEnum::COMPLETED);
        $queueEntity->setUpdatedAt(new \DateTime());
        $this->getEntityManager()->persist($queueEntity);
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
