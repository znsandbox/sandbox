<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\ShellNew\Legacy\PackageShell;

class ConfigureServerLampNpmShell extends BaseShell
{

    public function install()
    {
        $this->io->writeln('install npm ... ');

        $packageShell = new PackageShell($this->remoteShell);
        $packageShell->install('npm');

        echo ($this->remoteShell->runCommand('{{bin/npm}} --version')) . PHP_EOL;
    }

    public function config()
    {

    }

}
