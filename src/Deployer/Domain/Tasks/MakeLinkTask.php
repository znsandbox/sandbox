<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class MakeLinkTask extends BaseShell implements TaskInterface
{

    public $historySize;
    public $branch;

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $currentPath = VarProcessor::get('currentPath');
        $releasePath = VarProcessor::get('releasePath');
        //dd($releasePath, $linkPath);

        $fs = new FileSystemShell($this->remoteShell);
        $fs->removeFile($currentPath);
        $fs->makeLink($releasePath, $currentPath, '-s');
    }
}
