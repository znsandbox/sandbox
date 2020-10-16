<?php

use ZnLib\Db\Capsule\Manager;
use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use ZnLib\Console\Symfony4\Helpers\CommandHelper;

/**
 * @var Application $application
 * @var Container $container
 */

CommandHelper::registerFromNamespaceList([
    'ZnSandbox\Sandbox\Bot\Symfony\Commands',
    'ZnLib\Socket\Symfony4\Commands',
], $container);

/*
// --- Bot ---

use ZnSandbox\Sandbox\Bot\Symfony\Commands\BotCommand;

$command = new BotCommand;
$application->add($command);



// --- Queue ---

use ZnBundle\Queue\Symfony4\Commands\RunCommand;
use Symfony\Component\DependencyInjection\Container;
use ZnBundle\Queue\Domain\Services\JobService;
use ZnBundle\Queue\Domain\Repositories\Eloquent\JobRepository;

$container = new Container;
$jobRepository = new JobRepository($capsule);
$jobService = new JobService($jobRepository, $container);

$command = new RunCommand();
$application->add($command);*/
