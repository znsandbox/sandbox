<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Libs\VapeclubKz;

use ZnCore\Base\Helpers\DeprecateHelper;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\UrlEntity;

DeprecateHelper::hardThrow();

class ListUrl
{

    public function generate(string $path, int $page = 1, int $limit = null): string
    {
        $urlEntity = new UrlEntity();
        $urlEntity->setScheme('https');
        $urlEntity->setHost('vapeclub.kz');
        $urlEntity->setPath($path);
        $urlEntity->setQueryParam('limit', $limit);
        $urlEntity->setQueryParam('page', $page);
        return $urlEntity->__toString();

        /*$url = "https://vapeclub.kz/{$path}/";
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
        return $url;*/
    }
}
