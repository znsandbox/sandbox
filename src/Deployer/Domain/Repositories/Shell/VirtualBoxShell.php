<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\BaseShellDriver;

class VirtualBoxShell extends BaseShellDriver
{

    private $directory;

    public function setDirectory(string $directory): void
    {
        $this->directory = $directory;
    }

    public function shutDown(string $vmName)
    {
        try {
            $this->runCmd("VBoxManage controlvm \"$vmName\" acpipowerbutton");
        } catch (\Throwable $e) {
            
        }
    }

    public function startUp(string $vmName)
    {
        $this->runCmd("VBoxManage startvm \"$vmName\" --type headless");
    }

    protected function runCmd(string $cmd)
    {
        //"cd {$this->directory} && $cmd"
        return $this->shell->runCommand("$cmd");
    }
}
