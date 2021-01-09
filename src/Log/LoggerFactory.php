<?php

namespace ZnSandbox\Sandbox\Log;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Domain\Interfaces\DomainInterface;
use ZnSandbox\Sandbox\Log\Domain\Monolog\Handler\EloquentHandler;

class LoggerFactory
{

    public static function createLogger($container): LoggerInterface
    {
        /**
         * @var ContainerInterface $container
         * @var EloquentHandler $eloquentHandler
         */
        $eloquentHandler = $container->get(EloquentHandler::class);
        $level = EnvHelper::isDev() ? Logger::DEBUG : Logger::ERROR;
        $eloquentHandler->setLevel($level);
        return new Logger('application', [$eloquentHandler]);
    }

    public static function createMonologLogger(string $env, string $directory, string $format = 'json'): LoggerInterface
    {
        $formatMap = [
            'json' => \Monolog\Formatter\JsonFormatter::class,
            'html' => \Monolog\Formatter\HtmlFormatter::class,
            'log' => \Monolog\Formatter\LineFormatter::class,
        ];
        $formatterClass = $formatMap[$format];
        $logFileName = __DIR__ . '/../../../../../' . $directory . '/' . $env . '.' . $format;
        if($env == 'dev') {
            $level = Logger::DEBUG;
        } else {
            $level = Logger::ERROR;
        }
        $logger = new Logger('application');
        $handler = new StreamHandler($logFileName, $level);
        $handler->setFormatter(new \Monolog\Formatter\JsonFormatter);
        $logger->pushHandler($handler);
        //$repo = new \ZnSandbox\Sandbox\Log\JsonRepository;
        //prr($repo->all());

        return $logger;
    }

    public static function createYiiLogger(string $env): LoggerInterface
    {
        $logger = new \ZnSandbox\Sandbox\Log\Yii2\Logger;
        return $logger;
    }

}
