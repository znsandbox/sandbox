<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Services\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PackageShell;

class ConfigureServerLampNpmShell extends BaseShell
{

    public function install()
    {
        $this->io->writeln('install npm ... ');

        $packageShell = new PackageShell($this->remoteShell);
        $packageShell->install('npm');

        $version = $this->remoteShell->runCommand('{{bin/npm}} --version');

        echo '  ' . $version . PHP_EOL;
    }

    public function config()
    {

    }

}
