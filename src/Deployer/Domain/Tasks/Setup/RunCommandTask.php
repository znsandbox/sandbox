<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PackageShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class RunCommandTask extends BaseShell implements TaskInterface
{

    protected $title = 'Run "{{command}}"';
    public $command = null;

    public function run()
    {
//        $this->io->writeln("run \"{$this->command}\" ... ");
        $this->remoteShell->runCommand($this->command);
    }
}
