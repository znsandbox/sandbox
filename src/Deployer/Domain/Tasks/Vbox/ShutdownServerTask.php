<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\Shell\LocalShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\VirtualBoxShell;

class ShutdownServerTask extends BaseShell implements TaskInterface
{

    protected $title = 'VirtualBox. Shutdown server';
    public $name;

    public function __construct(BaseShellNew $remoteShell, IO $io)
    {
        $this->localShell = new LocalShell();
        $this->remoteShell = new LocalShell();
        $this->io = $io;
    }

    public function run()
    {
        $virtualBox = new VirtualBoxShell($this->localShell);
        $virtualBox->shutDown($this->name);
    }
}