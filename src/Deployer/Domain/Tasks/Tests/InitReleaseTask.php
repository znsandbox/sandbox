<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Tests;

use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;
use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;

class InitReleaseTask extends BaseShell implements TaskInterface
{

    protected $title = 'Init release';
    public $historySize;
    public $branch;

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $basePath = VarProcessor::get('basePath');
        $currentPath = $basePath . '/current';
        VarProcessor::set('currentPath', $currentPath);
        VarProcessor::set('releasePath', $currentPath);
    }
}
