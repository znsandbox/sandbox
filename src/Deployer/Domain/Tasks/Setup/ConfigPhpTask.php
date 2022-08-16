<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PhpShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ConfigPhpTask extends BaseShell implements TaskInterface
{

    protected $title = 'PHP config';
    public $phpConfig = [];
    private $defaultPhpConfig = [
        'short_open_tag' => 'On',
        'memory_limit' => '512M',
        'max_input_time' => '600',
        'max_execution_time' => '120',
    ];

    public function run()
    {
        $config = ArrayHelper::merge($this->defaultPhpConfig, $this->phpConfig);

        $fs = new FileSystemShell($this->remoteShell);
        $php = new PhpShell($this->remoteShell);

        $fs->sudo()->chmod('/etc/php', 'ugo+rwx', true);

        $php->setConfig('/etc/php/7.2/apache2/php.ini', [
            'short_open_tag' => $config['short_open_tag'],
        ]);
        $php->setConfig('/etc/php/7.2/cli/php.ini', [
            'short_open_tag' => $config['short_open_tag'],
            'memory_limit' => $config['memory_limit'],
            'max_input_time' => $config['max_input_time'],
            'max_execution_time' => $config['max_execution_time'],
        ]);
    }
}
