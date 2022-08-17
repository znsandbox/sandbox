<?php

return [
    'title' => 'Install development. Common',
    'tasks' => [
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\InstallLinuxPackageTask::class,
            'package' => 'git',
            'withUpdate' => true,
//        'title' => '',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\InstallLinuxPackageTask::class,
            'package' => 'apache2',
//        'title' => '',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\ApacheConfigModRewriteTask::class,
            'status' => true,
//        'title' => '',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\SetPermissionTask::class,
//        'title' => '',
            'config' => [
                [
                    'path' => '/etc/apache2',
                    'permission' => 'ugo+rwx',
                ],
                [
                    'path' => '/var/www',
                    'owner' => '{{userName}}:www-data',
                    'permission' => 'g+s',
                ],
            ],
        ],
        
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\MakeSoftLinkTask::class,
            'sourceFilePath' => '/etc/apache2/sites-available',
            'linkFilePath' => '/etc/apache2/sites-enabled',
            'title' => 'Make Soft Link "sites-enabled" -> "sites-available"',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\CopyToRemoteTask::class,
            'sourceFilePath' => realpath(__DIR__ . '/../../../../resources/apache2.conf'),
            'destFilePath' => '/etc/apache2/apache2.conf',
            'title' => 'Copy Apahe2 config to server',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\ApacheConfigAutorunTask::class,
            'status' => true,
//        'title' => '',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\ApacheRestartTask::class,
//        'title' => '',
        ],
    ],
];
