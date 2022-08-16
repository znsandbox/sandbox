<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ZnInitTask extends BaseShell implements TaskInterface
{

    protected $title = 'ZN init';
    public $profile;

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $envName = $profileConfig['env'] ?? null;

        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory(VarProcessor::get('releasePath'));
        $zn->init($this->profile);
    }
}
