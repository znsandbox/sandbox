<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\BaseShellNew2;

class ComposerShell extends BaseShellNew2
{

    public function install(string $directory)
    {
        $command = "cd $directory && {{bin/composer}} install";
        return $this->shell->runCommand($command);
    }
}
