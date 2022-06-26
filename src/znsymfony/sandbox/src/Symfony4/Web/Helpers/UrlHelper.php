<?php

namespace ZnSymfony\Sandbox\Symfony4\Web\Helpers;

use ZnCore\Base\Text\Helpers\Inflector;
use ZnLib\Web\Components\Url\Helpers\Url;

class UrlHelper
{

    public static function getSector(string $sectorIndex): ?string
    {
        $currentUri = Url::getBaseUrl();
        $currentUriArr = explode('/', trim($currentUri, '/'));
        $currentModule = $currentUriArr[$sectorIndex] ?? null;
        return $currentModule;
    }

    public static function generateUri(string $moduleId, string $controllerId = null, string $actionName = null): string
    {
        $uri = '/' . Inflector::camel2id($moduleId);
        if($controllerId) {
            $uri .= '/' . Inflector::camel2id($controllerId);
        }
        if ($actionName) {
            $uri .= '/' . Inflector::camel2id($actionName);
        }
        return $uri;
    }
}
