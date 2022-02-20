<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use Illuminate\Support\Collection;
use Incloud\Packages\Shop\Domain\Entities\BrandEntity;
use Incloud\Packages\Shop\Domain\Entities\CategoryEntity;
use Incloud\Packages\Shop\Domain\Entities\ModelEntity;
use Incloud\Packages\Shop\Domain\Entities\ProductEntity;
use Incloud\Packages\Shop\Domain\Enums\ProductTypeEnum;
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
            
            $companyId = 3;

            $productEntity = new ProductEntity();

            $productEntity->setTitle($item['title']);
            $productEntity->setModel($item['model']);
            $productEntity->setDescription($item['description']);
            $productEntity->setShortDescription($item['shortDescription'] ?? null);
            $productEntity->setPrice($item['price']['amount']);
            $productEntity->setTypeId(ProductTypeEnum::PRODUCT);
            $productEntity->setCompanyId($companyId);
            $productEntity->setImageUrl($item['mainImageUrl']);
            $productEntity->setSourceUrl($item['sourceUrl']);
            $productEntity->setAttributes($item['attributes']);
            
            if($item['brand']) {
                $brandEntity = new BrandEntity();
                $brandEntity->setTitle($item['brand']);
                $this->getEntityManager()->persist($brandEntity);
                $productEntity->setBrandId($brandEntity->getId());
//                dd($brandEntity);
                if($item['model']) {
                    $modelEntity = new ModelEntity();
                    $modelEntity->setBrandId($brandEntity->getId());
                    $modelEntity->setTitle($item['model']);
                    $this->getEntityManager()->persist($modelEntity);
                    $productEntity->setModelId($modelEntity->getId());
                }
            }

            

            $categoryEntity = new CategoryEntity();
            $categoryEntity->setCompanyId($companyId);
            $categoryEntity->setParentId(39);
            $categoryEntity->setTitle($item['categoryTitle']);
//            $categoryEntity = $this->getEntityManager()->oneByUnique($categoryEntity);

//            dd($productEntity);
            
            $this->getEntityManager()->persist($categoryEntity);
            $productEntity->setCategoryId($categoryEntity->getId());
            $this->getEntityManager()->persist($productEntity);
//            dd($productEntity);

//            dd($item['categoryTitle']);

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
