<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\LinuxPackage;

use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PackageShell;
use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;

class InstallLinuxPackageTask extends BaseShell implements TaskInterface
{

    public $package = null;
    public $withUpdate = false;

//    protected $title = 'Install packags "{{package}}"';

    public function getTitle(): ?string
    {
        if (is_array($this->package)) {
            $package = implode(', ', VarProcessor::processList($this->package));
        } else {
            $package = VarProcessor::process($this->package);
        }
        return "Install packages \"{$package}\"";
    }

    public function run()
    {
        $packageShell = new PackageShell($this->remoteShell);
        if ($this->withUpdate) {
            $packageShell->update();
        }
        if (is_array($this->package)) {
            $packageShell->installBatch(VarProcessor::processList($this->package));
        } else {
            $packageShell->install(VarProcessor::process($this->package));
        }
    }
}
