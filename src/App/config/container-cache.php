<?php

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Libs\App\Helpers\EnvHelper;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Base\Libs\DotEnv\DotEnvConfig;
use ZnCore\Base\Libs\DotEnv\DotEnvConfigInterface;

return [
    'definitions' => [],
    'singletons' => [
        AdapterInterface::class => function (ContainerInterface $container) {
            if (EnvHelper::isTest() || EnvHelper::isDev()) {
                $adapter = new \Symfony\Component\Cache\Adapter\ArrayAdapter();
            } else {
                $cacheDirectory = __DIR__ . '/../../../../../../' . DotEnv::get('CACHE_DIRECTORY');
                $adapter = new FilesystemAdapter('app', TimeEnum::SECOND_PER_DAY, $cacheDirectory);
                $adapter->setLogger($container->get(LoggerInterface::class));
            }
            return $adapter;
        },
        CacheInterface::class => AdapterInterface::class,
    ],
];