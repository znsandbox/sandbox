<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\PackageShell;

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
