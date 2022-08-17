<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Apache;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class ApacheConfigAutorunTask extends BaseShell implements TaskInterface
{

    protected $title = 'Apache2 enable autorun';
    public $status;
    
    public function run()
    {
        $apacheShell = new ApacheShell($this->remoteShell);
        if($this->status) {
            $apacheShell->enableAutorun();
        } else {
            $apacheShell->disableAutorun();
        }
    }
}
