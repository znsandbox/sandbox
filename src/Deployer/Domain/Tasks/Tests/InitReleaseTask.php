<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Tests;

use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;

class InitReleaseTask extends BaseShell implements TaskInterface
{

    protected $title = 'Init release';
    public $historySize;
    public $branch;

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $basePath = VarProcessor::get('basePath');
        $currentPath = $basePath . '/tests';
        VarProcessor::set('currentPath', $currentPath);
        VarProcessor::set('releasePath', $currentPath);
    }
}
