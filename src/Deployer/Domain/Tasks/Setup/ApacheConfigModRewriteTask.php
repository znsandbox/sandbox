<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ApacheConfigModRewriteTask extends BaseShell implements TaskInterface
{

    public $status;
    protected $title = 'Apache2 enable mod rewrite';
    
    public function run()
    {
        $apacheShell = new ApacheShell($this->remoteShell);
        if($this->status) {
            $apacheShell->enableRewrite();
        } else {
            $apacheShell->enableRewrite();
        }
    }
}
