<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ZnInitTask extends BaseShell implements TaskInterface
{

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $envName = $profileConfig['env'];

        $this->io->writeln('zn init ... ');
//        $this->init($profileConfig['env']);

        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory($profileConfig['release_path']);
        $zn->init($envName);
    }

    protected function init(string $envName)
    {

    }
}
