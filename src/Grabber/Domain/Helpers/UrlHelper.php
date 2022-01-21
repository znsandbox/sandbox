<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Helpers;

use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\UrlEntity;

class UrlHelper
{

    public static function parse(string $url): array
    {
        $urlArr = parse_url($url);
        $queryParts = null;
        if (!empty($urlArr['query'])) {
            parse_str($urlArr['query'], $queryParts);
        }
        $urlArr['queryParams'] = $queryParts;
        $urlArr['path'] = trim($urlArr['path'], '/');
        return $urlArr;
    }

    public static function forgeUrlByQueueEntity(QueueEntity $queueEntity): string {
        $urlEntity = new UrlEntity();
        $urlEntity->setHost($queueEntity->getSite()->getHost());
        $urlEntity->setPath($queueEntity->getPath());
        $urlEntity->setQueryParams($queueEntity->getQuery());
        $urlEntity->setScheme('https');
        return $urlEntity->__toString();
    }
}
