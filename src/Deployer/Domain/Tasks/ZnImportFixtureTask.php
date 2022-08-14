<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ZnImportFixtureTask extends BaseShell implements TaskInterface
{

    public $env = null;

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $this->io->writeln('zn import fixture ... ');
//        $this->fixtureImport($profileConfig['env']);

        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory(VarProcessor::get('releasePath'));
        $zn->fixtureImport($this->env);
    }

    protected function fixtureImport(string $envName)
    {

    }
}
