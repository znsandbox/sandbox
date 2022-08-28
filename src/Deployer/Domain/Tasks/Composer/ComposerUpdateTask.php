<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Composer;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ComposerShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class ComposerUpdateTask extends BaseShell implements TaskInterface
{

    protected $title = 'Composer update';
    public $noDev;
    public $directory;

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $this->updateDependency($profileName);
    }

    protected function updateDependency(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $composer = new ComposerShell($this->remoteShell);
        $composer->setDirectory($this->directory);

        $options = '';
        if($this->noDev) {
            $options .= ' --no-dev ';
        }

        $composer->update($options);
    }
}
