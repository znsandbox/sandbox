<?php

namespace ZnSandbox\Sandbox\Yii2\App;

use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnSandbox\Sandbox\Yii2\App\Loader\BaseLoader;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Kernel
{

    private $cache;
    private $loader;
    private $env;

    public function __construct(array $env, BaseLoader $loader = null)
    {
        $this->loader = $loader;
        $this->env = $env;
        //$this->initCache($env);
    }

    public function run()
    {
        $this->init($this->env);
        $appName = $this->env['APP_NAME'];
        Constant::defineBase(realpath(__DIR__ . '/../../../../../..'));
        Constant::defineApp($appName);
        $config = $this->loadMainConfig($appName);
        return $config;
    }

    private function init(array $env)
    {
        define('MICRO_TIME', microtime(true));
        Constant::defineEnv($env);
        $this->loader->loadYii();
    }

    private function loadMainConfig(string $appName): array
    {
        $this->loader->bootstrapApp($appName);
        $config = $this->loader->loadMainConfig($appName);
        return $config;
    }

    private function initCache(array $env)
    {
        $cacheDirectory = FileHelper::path($env['CACHE_DIRECTORY']);
        $this->cache = new FilesystemAdapter('kernel', TimeEnum::SECOND_PER_MINUTE * 20, $cacheDirectory);
    }

}
