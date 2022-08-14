<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\BaseShellDriver;

class ComposerShell extends BaseShellDriver
{

    public function install(string $options = null)
    {
        $command = "{{bin/composer}} install {$options}";
        $this->runCommand($command);
//        return $this->shell->runCommand($command, $this->getDirectory());
    }

    public function update(string $options = null)
    {
        $command = "{{bin/composer}} update {$options}";
        $this->runCommand($command);
//        return $this->shell->runCommand($command, $this->getDirectory());
    }
}
