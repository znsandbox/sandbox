<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\ShellNew\Legacy\PackageShell;

class ConfigureServerLampNpmShell extends BaseShell
{

    public function install()
    {
        $packageShell = new PackageShell($this->remoteShell);
        $packageShell->install('npm');
    }

    public function config()
    {

    }

}
