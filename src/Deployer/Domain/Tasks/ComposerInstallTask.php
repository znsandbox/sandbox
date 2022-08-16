<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ComposerShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ComposerInstallTask extends BaseShell implements TaskInterface
{

    public $noDev;
    protected $title = 'Composer install';

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $this->installDependency($profileName);
    }

    protected function installDependency(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $composer = new ComposerShell($this->remoteShell);
        $composer->setDirectory(VarProcessor::get('releasePath'));
        $options = '';
        if($this->noDev) {
            $options .= ' --no-dev ';
        }
        $composer->install($options);
    }
}
