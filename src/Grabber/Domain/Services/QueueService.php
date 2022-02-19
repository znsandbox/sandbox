<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use Illuminate\Support\Collection;
use Incloud\Packages\Shop\Domain\Entities\ProductEntity;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Grabber\Domain\Dto\TotalDto;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\ContentEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\SiteEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\UrlEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Enums\QueueStatusEnum;
use ZnSandbox\Sandbox\Grabber\Domain\Enums\QueueTypeEnum;
use ZnSandbox\Sandbox\Grabber\Domain\Helpers\UrlHelper;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\QueueRepositoryInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\SiteServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Libs\VapeclubKz\ItemParser;
use ZnSandbox\Sandbox\Grabber\Domain\Libs\VapeclubKz\ListParser;
use ZnSandbox\Sandbox\Grabber\Domain\Libs\VapeclubKz\PaginatorParser;

/**
 * @method QueueRepositoryInterface getRepository()
 */
class QueueService extends BaseCrudService implements QueueServiceInterface
{

    private $siteService;

    public function __construct(EntityManagerInterface $em, SiteServiceInterface $siteService)
    {
        $this->setEntityManager($em);
        $this->siteService = $siteService;
    }

    public function getEntityClass(): string
    {
        return QueueEntity::class;
    }

    public function addLink(string $url, string $type)
    {
        $queueEntity = $this->createEntityByUrl($url);
        try {
            $queueEntityUnq = $this->getEntityManager()->oneByUnique($queueEntity);
        } catch (NotFoundException $e) {
            $queueEntity->setType($type);
//            $queueEntity->setStatusId(QueueStatusEnum::PARSED);
            $this->getEntityManager()->persist($queueEntity);
        }
    }

    public function allNew(): Collection
    {
        return $this->getRepository()->allNew();
    }

    public function allGrabed(): Collection
    {
        return $this->getRepository()->allGrabed();
    }

    public function runAll()
    {
        $queueCollection = $this->getRepository()->allNew();
        foreach ($queueCollection as $queueEntity) {
            $this->runOne($queueEntity);
        }
    }

    public function lastUpdateTime(Query $query = null): \DateTime
    {
        $qeueEntity = $this->getRepository()->lastUpdate();
        if(!$qeueEntity->getUpdatedAt() || $qeueEntity->getCreatedAt() > $qeueEntity->getUpdatedAt()) {
            return $qeueEntity->getCreatedAt();
        } else {
            return $qeueEntity->getUpdatedAt();
        }
    }

    public function total(): TotalDto
    {
        $totalDto = new TotalDto();
        $totalDto->setAll($this->getRepository()->countAll());
        $totalDto->setNew($this->getRepository()->countNew());
        $totalDto->setGrabed($this->getRepository()->countGrabed());
        $totalDto->setParsed($this->getRepository()->countParsed());
        return $totalDto;
    }

    public function parseOne(QueueEntity $queueEntity)
    {
        
        if ($queueEntity->getType() == QueueTypeEnum::LIST) {
            $content = $queueEntity->getContent();
            $parser = new ListParser();
            $paginatorParser = new PaginatorParser();
            $pages = $paginatorParser->parse($content);

            $itemLinks = $parser->parse($content);

            $url = UrlHelper::forgeUrlByQueueEntity($queueEntity);


            foreach ($pages as $page) {
                $urlEntity = new UrlEntity($url);
                $urlEntity->setQueryParam('page', $page);
                $this->addLink($urlEntity->__toString(), QueueTypeEnum::LIST);
            }

            foreach ($itemLinks as $itemLink) {
                $this->addLink($itemLink, QueueTypeEnum::ITEM);
            }
            $queueEntity->setStatusId(QueueStatusEnum::PARSED);
            $this->getEntityManager()->persist($queueEntity);
        }

        if ($queueEntity->getType() == QueueTypeEnum::ITEM) {
            $queueEntity->setStatusId(QueueStatusEnum::PARSED);
            $parser = new ItemParser();
            $item = $parser->parse($queueEntity->getContent());

            $productEntity = new ProductEntity();

            $productEntity->setTitle($item['title']);
            $productEntity->setDescription($item['description']);
            $productEntity->setShortDescription($item['shortDescription']);
            $productEntity->setPrice($item['price']['amount']);
//            $productEntity->set($item['']);



            dd($item);

            $this->getEntityManager()->persist($queueEntity);
        }

        if ($queueEntity->getType() == QueueTypeEnum::COMMON) {
            $queueEntity->setStatusId(QueueStatusEnum::PARSED);
            $this->getEntityManager()->persist($queueEntity);
        }

        $contentEntity = new ContentEntity();
        $contentEntity->setPageId($queueEntity->getId());
        $contentEntity->setContent($queueEntity->getContent());
//        dump($contentEntity);
        $this->getEntityManager()->persist($contentEntity);

        //dd($queueEntity);
    }

    /*private function forgeUrlByQueueEntity(QueueEntity $queueEntity): string {
        $urlEntity = new UrlEntity();
        $urlEntity->setHost($queueEntity->getSite()->getHost());
        $urlEntity->setPath($queueEntity->getPath());
        $urlEntity->setQueryParams($queueEntity->getQuery());
        $urlEntity->setScheme('https');
        return $urlEntity->__toString();
    }*/

    public function runOne(QueueEntity $queueEntity)
    {
        $url = UrlHelper::forgeUrlByQueueEntity($queueEntity);
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

    public function persistByUrl(string $url): QueueEntity
    {
        $queueEntity = $this->createEntityByUrl($url);
        $this->getEntityManager()->persist($queueEntity);
        return $queueEntity;
    }

    public function createEntityByUrl(string $url): QueueEntity
    {
        $siteEntity = $this->siteService->forgeEntityByUrl($url);

        $urlArr = UrlHelper::parse($url);

        /*$siteEntity = new SiteEntity();
        $siteEntity->setHost($urlArr['host']);
        $this->getEntityManager()->persist($siteEntity);*/

        $queueEntity = new QueueEntity();
        $queueEntity->setSiteId($siteEntity->getId());
        $queueEntity->setPath($urlArr['path']);
        $queueEntity->setQuery($urlArr['queryParams']);
        $queueEntity->setType(QueueTypeEnum::COMMON);
        return $queueEntity;
    }
}
