<?php

use Psr\Log\LoggerInterface;
use ZnSandbox\Sandbox\Log\LoggerFactory;

return [
    'singletons' => [
        'ZnSandbox\Sandbox\Log\Domain\Interfaces\Repositories\LogRepositoryInterface' => 'ZnSandbox\Sandbox\Log\Domain\Repositories\Eloquent\LogRepository',
        LoggerInterface::class => function ($container) {
            return LoggerFactory::createLogger($container);
        },
    ],
];
