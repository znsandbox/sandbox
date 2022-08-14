<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class RestartApacheTask extends BaseShell implements TaskInterface
{

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $this->io->writeln('restart apache ... ');
        $this->apacheRestart();
    }

    protected function apacheRestart()
    {
        $apache = new ApacheShell($this->remoteShell);
        $apache->restart();
    }
}
