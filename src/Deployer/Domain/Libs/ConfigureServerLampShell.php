<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnLib\Console\Domain\ShellNew\Legacy\PackageShell;
use ZnSandbox\Sandbox\Deployer\Domain\Shell\LocalShell;

class ConfigureServerLampShell
{

    private $localShell;
    private $remoteShell;
    private $io;

    public function __construct(BaseShellNew $remoteShell, IO $io)
    {
        $this->localShell = new LocalShell();
        $this->remoteShell = $remoteShell;
        $this->io = $io;
    }

    public function installApache()
    {
        $packageShell = new PackageShell($this->remoteShell);
        $packageShell->install('apache2');
    }

}
