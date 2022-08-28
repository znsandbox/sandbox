<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Composer;

use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;
use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;
use ZnLib\Components\ShellRobot\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ComposerShell;

class ComposerInstallTask extends BaseShell implements TaskInterface
{

    public $noDev;
    public $directory;
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
        $composer->setDirectory($this->directory);
        $options = '';
        if ($this->noDev) {
            $options .= ' --no-dev ';
        }
        $composer->install($options);
    }
}
