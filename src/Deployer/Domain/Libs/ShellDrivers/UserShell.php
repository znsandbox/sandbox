<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\BaseShellNew2;
use function Deployer\askHiddenResponse;

class UserShell extends BaseShellNew2
{

    public function setSudoPassword(): void
    {
        $pass = askHiddenResponse('Input sudo password:');
        $this->fsClass()::uploadContent($pass, '~/sudo-pass');
    }
}
