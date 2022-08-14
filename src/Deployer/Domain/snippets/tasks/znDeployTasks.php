<?php

use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ComposerInstallTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ConfigureDomainTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\GitCloneTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\InitReleaseTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\MakeLinkTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\RestartApacheTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\SetPermissionTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ZnImportFixtureTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ZnInitTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ZnMigrateUpTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ZnReloadWebSocketFixtureTask;

return [
    [
        'class' => InitReleaseTask::class,
    ],
    [
        'class' => GitCloneTask::class,
        'repository' => '{{gitRepository}}',
        'branch' => '{{gitBranch}}',
    ],
    [
        'class' => ComposerInstallTask::class,
//            'noDev' => true,
    ],
    [
        'class' => SetPermissionTask::class,
        'config' => [
            [
                'path' => '{{releasePath}}/var',
                'permission' => 'a+w',
            ],
            [
                'path' => '{{releasePath}}/public/uploads',
                'permission' => 'a+w',
            ],
        ],
    ],
    [
        'class' => ZnInitTask::class,
        'profile' => '{{znInitProfile}}',
    ],
    [
        'class' => ZnMigrateUpTask::class,
    ],
    [
        'class' => ZnImportFixtureTask::class,
    ],

    /*[
        'class' => ZnReloadWebSocketFixtureTask::class,
    ],*/

    [
        'class' => MakeLinkTask::class,
    ],
    [
        'class' => ConfigureDomainTask::class,
        'domains' => [
            [
                'domain' => '{{baseDomain}}',
                'directory' => '{{currentPath}}/public',
            ],
        ],
    ],
    [
        'class' => RestartApacheTask::class,
    ],
];

/*

Объявите переменные.

    'vars' => [
        'znInitProfile' => 'vbox',
//        'znEnv' => null,
        'basePath' => '{{deployBaseDir}}/my-group/my-project',
        'baseDomain' => 'myproject.ex',
        'gitRepository' => 'git@gitlab.com:my-group/my-project.git',
        'gitBranch' => 'master',
    ],

*/
