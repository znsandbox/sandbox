<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ZnInitTask extends BaseShell implements TaskInterface
{

    public $profile;

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $envName = $profileConfig['env'] ?? null;

        $this->io->writeln('zn init ... ');
//        $this->init($profileConfig['env']);
//dd(VarProcessor::get('release_path'));
        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory(VarProcessor::get('release_path'));
        $zn->init($this->profile);
    }

    protected function init(string $envName)
    {

    }
}
