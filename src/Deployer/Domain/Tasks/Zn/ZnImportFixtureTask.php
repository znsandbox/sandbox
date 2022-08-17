<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Zn;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class ZnImportFixtureTask extends BaseShell implements TaskInterface
{

    protected $title = 'Zn. Import fixture';
    public $env = null;

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory(VarProcessor::get('releasePath'));
        $zn->fixtureImport($this->env);
    }
}
