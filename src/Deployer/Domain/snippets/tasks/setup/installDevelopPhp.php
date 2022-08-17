<?php

return [
    'title' => 'Install development. PHP',
    'tasks' => [
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\LinuxPackage\AddPackageRepositoryTask::class,
            'repository' => 'ppa:ondrej/php',
//        'title' => '',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\LinuxPackage\InstallLinuxPackageTask::class,
            'package' => [
                '{{phpv}}',
                '{{phpv}}-cli',
                '{{phpv}}-common',
            ],
            'withUpdate' => true,
            'title' => '## Install base PHP packages',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\LinuxPackage\InstallLinuxPackageTask::class,
            'package' => [
                '{{phpv}}-gmp',
                '{{phpv}}-curl',
                '{{phpv}}-zip',
                '{{phpv}}-gd',
                '{{phpv}}-json',
                '{{phpv}}-mbstring',
                '{{phpv}}-intl',
                '{{phpv}}-mysql',
                '{{phpv}}-sqlite3',
                '{{phpv}}-xml',
                '{{phpv}}-zip',
                '{{phpv}}-imagick',
            ],
            'withUpdate' => true,
            'title' => '## Install ext PHP packages',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\ConfigPhpTask::class,
//            'title' => '',
        ],
        [
            'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Composer\InstallComposerToSystemTask::class,
//            'title' => '',
        ],
    ],
];
