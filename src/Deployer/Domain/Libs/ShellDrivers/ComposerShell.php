<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\BaseShellDriver;

class ComposerShell extends BaseShellDriver
{

    public function install(string $directory)
    {
        $command = "cd $directory && {{bin/composer}} install";
        return $this->shell->runCommand($command);
    }
}
