<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PackageShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class RunCommandTask extends BaseShell implements TaskInterface
{

    protected $title = 'Run "{{command}}"';
    public $command = null;

    public function run()
    {
        $this->remoteShell->runCommand($this->command);
    }
}
