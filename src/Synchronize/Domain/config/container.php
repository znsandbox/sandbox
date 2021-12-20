<?php

use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Base\Libs\Store\StoreFile;
use ZnSandbox\Sandbox\Synchronize\Domain\Interfaces\Services\SynchronizeServiceInterface;
use ZnSandbox\Sandbox\Synchronize\Domain\Services\SynchronizeService;

return [
    'singletons' => [
//		'ZnSandbox\\Sandbox\\Synchronize\\Domain\\Interfaces\\Services\\SynchronizeServiceInterface' => 'ZnSandbox\\Sandbox\\Synchronize\\Domain\\Services\\SynchronizeService',
        SynchronizeServiceInterface::class => function (ContainerInterface $container) {
            /** @var SynchronizeService $service */
            $service = $container->get(SynchronizeService::class);
            $configFile = DotEnv::get('SYNCHRONIZE_CONFIG_FILE');
            $store = new StoreFile($configFile);
            $config = $store->load();
            $service->setConfig($config);
            return $service;
        },
    ],
];