<?php

use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Composer\ComposerInstallTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Deploy\ConfigureDomainTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Git\GitCloneTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Deploy\InitReleaseTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Deploy\MakeLinkForCurrentReleaseTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common\RestartApacheTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common\SetPermissionTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Zn\ZnImportFixtureTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Zn\ZnInitTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Zn\ZnMigrateUpTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\Zn\ZnReloadWebSocketFixtureTask;

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
        'class' => MakeLinkForCurrentReleaseTask::class,
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
