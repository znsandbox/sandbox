<?php

return [
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\AddPackageRepositoryTask::class,
        'repository' => 'ppa:ondrej/php',
//        'title' => '',
    ],
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\InstallLinuxPackageTask::class,
        'package' => [
            '{{phpv}}',
            '{{phpv}}-cli',
            '{{phpv}}-common',
        ],
        'withUpdate' => true,
        'title' => '## Install base PHP packages',
    ],
    [
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\InstallLinuxPackageTask::class,
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
        'class' => \ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup\InstallComposerTask::class,
//            'title' => '',
    ],
];
