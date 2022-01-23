<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Services;

use Symfony\Component\DomCrawler\Crawler;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\MetaEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Helpers\ParseHelper;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Repositories\MetaRepositoryInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\MetaServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\SiteServiceInterface;

function unicode_decode($str)
{
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $str);
}

/**
 * @method MetaRepositoryInterface getRepository()
 */
class MetaService extends BaseCrudService implements MetaServiceInterface
{

    private $siteService;
    private $queueService;

    public function __construct(EntityManagerInterface $em, SiteServiceInterface $siteService, QueueServiceInterface $queueService)
    {
        $this->setEntityManager($em);
        $this->siteService = $siteService;
        $this->queueService = $queueService;
    }

    public function getEntityClass(): string
    {
        return MetaEntity::class;
    }

    public function oneByHtml(string $html): MetaEntity
    {
        $crawler = new Crawler($html);
        $title = ParseHelper::parseTitle($crawler);
        $meta = ParseHelper::parseMeta($crawler);
        $props = [];
        $props['title'] = $title ?? $meta['name']['title'] ?? $meta['property']['og']['title'];
        $image = is_array(ArrayHelper::getValue($meta, ['property', 'og', 'image'])) ? ArrayHelper::getValue($meta, ['property', 'og', 'image', 0]) : ArrayHelper::getValue($meta, ['property', 'og', 'image']);
        $props['image'] = $image;
        $props['description'] = $meta['name']['description'] ?? $meta['property']['og']['description'] ?? null;
        $props['keywords'] = $meta['name']['keywords'] ?? $meta['property']['og']['keywords'] ?? null;
        $props['site_name'] = $meta['property']['og']['site_name'] ?? $meta['property']['al']['ios']['app_name'] ?? $meta['property']['al']['android']['app_name'] ?? null;
        $props['url'] = $meta['property']['og']['url'] ?? $url;
        $props['type'] = $meta['property']['og']['type'] ?? null;
        $props['video'] = $meta['property']['og']['video'] ?? null;

        $keywords = $props['keywords'];

//        $siteEntity = $this->siteService->forgeEntityByUrl($props['url']);

        $queueEntity = $this->queueService->persistByUrl($props['url']);

        $metaEntity = new MetaEntity();
        $metaEntity->setPageId($queueEntity->getId());
        $metaEntity->setTitle($props['title']);
        $metaEntity->setSiteName($props['site_name']);
        $metaEntity->setType($props['type']);
        $metaEntity->setDescription($props['description']);
        $metaEntity->setKeywords($keywords);
        $metaEntity->setImage($image);
        $metaEntity->setAttributes($meta['all']);
        $this->getEntityManager()->persist($metaEntity);
//        dd($queueEntity);
        /*try {


        } catch (\Exception $e) {
            dd($e);
        }*/

        return $metaEntity;
    }

    public function oneByUrl(string $url): MetaEntity
    {
        $html = file_get_contents($url);
        return $this->oneByHtml($html);
    }
}

