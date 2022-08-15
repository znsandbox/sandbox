<?php

return [
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\RegisterPublicKeyTask::class,
    ],
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\SetSudoPasswordTask::class,
    ],
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\InstallLinuxPackageTask::class,
        'package' => 'git',
    ],
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\InstallLinuxPackageTask::class,
        'package' => 'apache2',
    ],
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\RunCommandTask::class,
        'command' => 'sudo a2enmod rewrite',
        'description' => 'apache2 enableRewrite',
    ],
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\SetPermissionTask::class,
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

    // linkSitesEnabled

    // update apache2 config

    // enable apache2 autorun

    // apache2 restart

];
