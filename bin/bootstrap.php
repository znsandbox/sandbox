<?php

use PhpLab\Eloquent\Db\Helpers\Manager;
use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use PhpLab\Core\Console\Helpers\CommandHelper;

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
    'PhpLab\Sandbox\Bot\Symfony\Commands',
    'PhpLab\Sandbox\Socket\Symfony\Commands',
], $container);

/*
// --- Bot ---

use PhpLab\Sandbox\Bot\Symfony\Commands\BotCommand;

$command = new BotCommand;
$application->add($command);



// --- Queue ---

use PhpBundle\Queue\Symfony\Commands\RunCommand;
use Symfony\Component\DependencyInjection\Container;
use PhpBundle\Queue\Domain\Services\JobService;
use PhpBundle\Queue\Domain\Repositories\Eloquent\JobRepository;

$container = new Container;
$jobRepository = new JobRepository($capsule);
$jobService = new JobService($jobRepository, $container);

$command = new RunCommand();
$application->add($command);*/
