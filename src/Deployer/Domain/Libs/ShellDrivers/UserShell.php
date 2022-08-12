<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\BaseShellDriver;
use function Deployer\askHiddenResponse;

class UserShell extends BaseShellDriver
{

    public function setSudoPassword(): void
    {
        $pass = askHiddenResponse('Input sudo password:');
        $this->fsClass()::uploadContent($pass, '~/sudo-pass');
    }
}
