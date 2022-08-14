<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ZnImportFixtureTask extends BaseShell implements TaskInterface
{

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $envName = $profileConfig['env'];

        $this->io->writeln('zn import fixture ... ');
//        $this->fixtureImport($profileConfig['env']);

        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory($profileConfig['release_path']);
        $zn->fixtureImport($envName);
    }

    protected function fixtureImport(string $envName)
    {

    }
}
