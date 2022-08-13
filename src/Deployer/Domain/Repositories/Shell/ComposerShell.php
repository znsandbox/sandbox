<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\BaseShellDriver;

class ComposerShell extends BaseShellDriver
{

    public function install(string $directory)
    {
        $command = "cd $directory && {{bin/composer}} install";
        return $this->shell->runCommand($command);
    }

    public function update(string $directory)
    {
        $command = "cd $directory && {{bin/composer}} update";
        return $this->shell->runCommand($command);
    }
}
