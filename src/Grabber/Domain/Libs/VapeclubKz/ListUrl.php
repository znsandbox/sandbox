<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Libs\VapeclubKz;

use ZnSandbox\Sandbox\Grabber\Domain\Entities\UrlEntity;

class ListUrl
{

    public function generate(string $path, int $page = 1, int $limit = null): string
    {
        $url = "https://vapeclub.kz/{$path}/";
        $query = [];
        if($limit) {
            $query['limit'] = $limit;
        }
        if($page) {
            $query['page'] = $page;
        }
        if(!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        return $url;
    }

    public function parse(string $url): UrlEntity {
        $urlArr = parse_url($url);
        $queryParts = null;
        if (!empty($urlArr['query'])) {
            parse_str($urlArr['query'], $queryParts);
        }
        $urlArr['queryParams'] = $queryParts;

        $urlArr['path'] = trim($urlArr['path'], '/');

        $urlEntity = new UrlEntity();
        $urlEntity->setScheme($urlArr['scheme']);
        $urlEntity->setHost($urlArr['host']);
        $urlEntity->setPath($urlArr['path']);
        $urlEntity->setQueryParams($urlArr['queryParams']);
        return $urlEntity;
    }
}
