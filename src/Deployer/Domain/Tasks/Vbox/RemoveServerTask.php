<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\Shell\LocalShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class RemoveServerTask extends BaseShell implements TaskInterface
{

    public $password = null;
    protected $title = 'VirtualBox. Remove server';

    public $vmDirectory;
    public $vmName;

    public function __construct(BaseShellNew $remoteShell, IO $io)
    {
        $this->localShell = new LocalShell();
        $this->remoteShell = new LocalShell();
        $this->io = $io;

//        $this->vmName = $_ENV['DEPLOYER_VIRTUAL_BOX_NAME'];
//        $this->vmDirectory = $_ENV['DEPLOYER_VIRTUAL_BOX_DIRECTORY'];
    }

    public function run()
    {
        $fs = new FileSystemShell($this->remoteShell);
        $fs->sudo()->removeDir($this->vmDirectory . '/' . $this->vmName);
    }
}
