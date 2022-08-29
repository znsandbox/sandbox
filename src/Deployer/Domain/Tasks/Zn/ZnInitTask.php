<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Zn;

use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;
use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;

class ZnInitTask extends BaseShell implements TaskInterface
{

    protected $title = 'Zn. Init env';
    public $profile;

    public function run()
    {
        $profileName = ShellFactory::getVarProcessor()->get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $envName = $profileConfig['env'] ?? null;

        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory(ShellFactory::getVarProcessor()->get('releasePath'));
        $zn->init($this->profile);
    }
}
