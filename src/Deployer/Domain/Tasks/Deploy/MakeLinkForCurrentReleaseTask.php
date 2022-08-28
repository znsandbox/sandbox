<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Deploy;

use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;
use ZnLib\Components\ShellRobot\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;

class MakeLinkForCurrentReleaseTask extends BaseShell implements TaskInterface
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
