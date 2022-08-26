<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell;

class PhpUnitShell extends BaseShellDriver
{

    public function run()
    {
        return $this->runCommand("{{bin/php}} vendor/phpunit/phpunit/phpunit");
    }
}
