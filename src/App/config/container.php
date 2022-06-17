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
use ZnDatabase\Fixture\Domain\Repositories\FileRepository;

return [
    'definitions' => [],
    'singletons' => [
        /*FileRepository::class => function () {
            return new FileRepository(DotEnv::get('ELOQUENT_CONFIG_FILE'));
        },*/
        LoggerInterface::class => \Psr\Log\NullLogger::class,
    ],
];