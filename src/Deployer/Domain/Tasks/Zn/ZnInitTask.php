<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Zn;

use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;
use ZnLib\Components\ShellRobot\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;

class ZnInitTask extends BaseShell implements TaskInterface
{

    protected $title = 'Zn. Init env';
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
