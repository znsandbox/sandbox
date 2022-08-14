<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\BaseShellDriver;

class ComposerShell extends BaseShellDriver
{

    public function install()
    {
        $command = "{{bin/composer}} install";
        $this->runCommand($command);
//        return $this->shell->runCommand($command, $this->getDirectory());
    }

    public function update()
    {
        $command = "{{bin/composer}} update";
        $this->runCommand($command);
//        return $this->shell->runCommand($command, $this->getDirectory());
    }
}
