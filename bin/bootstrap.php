<?php

use ZnCore\Db\Db\Helpers\Manager;
use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use ZnCore\Base\Console\Helpers\CommandHelper;

/**
 * @var Application $application
 * @var Container $container
 */

$container = Container::getInstance();

// --- Application ---

$container->bind(Application::class, Application::class, true);

// --- Database ---

$eloquentConfigFile = $_ENV['ELOQUENT_CONFIG_FILE'];
$capsule = new Manager(null, $eloquentConfigFile);

CommandHelper::registerFromNamespaceList([
    'ZnSandbox\Sandbox\Bot\Symfony\Commands',
    'ZnLib\Socket\Symfony\Commands',
], $container);

/*
// --- Bot ---

use ZnSandbox\Sandbox\Bot\Symfony\Commands\BotCommand;

$command = new BotCommand;
$application->add($command);



// --- Queue ---

use ZnBundle\Queue\Symfony\Commands\RunCommand;
use Symfony\Component\DependencyInjection\Container;
use ZnBundle\Queue\Domain\Services\JobService;
use ZnBundle\Queue\Domain\Repositories\Eloquent\JobRepository;

$container = new Container;
$jobRepository = new JobRepository($capsule);
$jobService = new JobService($jobRepository, $container);

$command = new RunCommand();
$application->add($command);*/
