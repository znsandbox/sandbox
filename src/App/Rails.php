<?php

namespace ZnSandbox\Sandbox\App;

use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\Env\DotEnvHelper;
use yii2rails\app\domain\helpers\Env;
use yii2rails\domain\base\BaseDomainLocator;
use yii2rails\domain\helpers\ConfigHelper;
use ZnCore\Base\Helpers\LoadHelper;

class Rails
{

    public static function initAll(string $rootDir = null)
    {
        self::init($rootDir);
        self::loadDomainConfig();
    }

    private static function init(string $rootDir = null)
    {
        $rootDir = $rootDir ?? FileHelper::rootPath();
        Env::load(DotEnvHelper::get());
        Constant::defineBase($rootDir);
    }

    private static function loadDomainConfig()
    {
        include __DIR__ . '/../../../../znsandbox/sandbox/src/YiiLegacy/yii2rails/app/domain/helpers/Func.php';
        include __DIR__ . '/App.php';
        $domainConfig = LoadHelper::loadScript('common/config/domains.php');
        foreach ($domainConfig as $domainId => &$definition) {
            $definition = ConfigHelper::normalizeItemConfig($domainId, $definition);
        }
        \App::$domain = new BaseDomainLocator(['components' => $domainConfig]);
    }

}
