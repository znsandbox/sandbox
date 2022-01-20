<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Helpers;

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
}
