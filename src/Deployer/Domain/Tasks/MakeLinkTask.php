<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class MakeLinkTask extends BaseShell implements TaskInterface
{

    protected $title = 'Make link';

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $currentPath = VarProcessor::get('currentPath');
        $releasePath = VarProcessor::get('releasePath');

        $fs = new FileSystemShell($this->remoteShell);
        $fs->removeFile($currentPath);
        $fs->makeLink($releasePath, $currentPath, '-s');
    }
}
