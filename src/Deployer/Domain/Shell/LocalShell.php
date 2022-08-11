<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Shell;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\VarProcessor;

class LocalShell extends BaseShellNew
{

    protected function prepareCommandString(string $commandString): string
    {
        $commandString = VarProcessor::process($commandString);
        return $commandString;
    }
}
