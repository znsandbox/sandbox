<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PackageShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class InstallLinuxPackageTask extends BaseShell implements TaskInterface
{

    public $package = null;

    public function run()
    {
        $this->io->writeln("install {$this->package} ... ");
        $packageShell = new PackageShell($this->remoteShell);
        $packageShell->update();
        $packageShell->install($this->package);
    }
}
