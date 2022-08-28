<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Services\Shell;

use ZnLib\Components\ShellRobot\Domain\Repositories\Shell\PackageShell;

class ConfigureServerLampGitShell extends BaseShell
{

    public function install()
    {
        $this->io->writeln('install git ... ');

        $packageShell = new PackageShell($this->remoteShell);
        $packageShell->update();
        $packageShell->install('git');
    }
}
