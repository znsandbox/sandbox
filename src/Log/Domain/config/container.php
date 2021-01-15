<?php

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use ZnCore\Base\Helpers\EnvHelper;
use ZnSandbox\Sandbox\Log\Domain\Interfaces\Repositories\LogRepositoryInterface;
use ZnSandbox\Sandbox\Log\Domain\Monolog\Handler\EloquentHandler;
use ZnSandbox\Sandbox\Log\Domain\Repositories\Eloquent\LogRepository;

return [
    'singletons' => [
        LogRepositoryInterface::class => LogRepository::class,
        HandlerInterface::class => function (ContainerInterface $container) {
            /**
             * @var ContainerInterface $container
             * @var AbstractProcessingHandler $handler
             */
            $driver = $_ENV['LOG_DRIVER'] ?? null;
            if ($driver == 'file') {
                $logFileName = __DIR__ . '/../../../../../../../' . $_ENV['LOG_DIRECTORY'] . '/application.json';
                $handler = new StreamHandler($logFileName);
                $formatterClass = $_ENV['LOG_FORMATTER'] ?? JsonFormatter::class;
                $formatter = $container->get($formatterClass);
                $handler->setFormatter($formatter);
            } elseif ($driver == 'db') {
                $handler = $container->get(EloquentHandler::class);
            } else {
//                $handler = new \Monolog\Handler\NullHandler();
                throw new Exception('Not found handler!');
            }
            return $handler;
        },
        LoggerInterface::class => function (ContainerInterface $container) {
            $driver = $_ENV['LOG_DRIVER'] ?? null;
            if ($driver == null) {
                $logger = new NullLogger('application');
            } else {
                $handler = $container->get(HandlerInterface::class);
                $level = EnvHelper::isDev() ? Logger::DEBUG : Logger::ERROR;
                $handler->setLevel($level);
                $logger = new Logger('application');
                $logger->pushHandler($handler);
            }
            return $logger;
        },
    ],
];
