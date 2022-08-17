<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\Shell;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;

class LocalShell extends BaseShellNew
{

    protected function prepareCommandString(string $commandString): string
    {
        $commandString = VarProcessor::process($commandString);
        return $commandString;
    }
}