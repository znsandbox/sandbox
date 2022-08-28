<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell;

use ZnLib\Components\ShellRobot\Domain\Base\BaseShellDriver;
use function Deployer\askHiddenResponse;

class UserShell extends BaseShellDriver
{

    public function setSudoPassword(): void
    {
        $pass = askHiddenResponse('Input sudo password:');
        $this->fsClass()::uploadContent($pass, '~/sudo-pass');
    }
}
