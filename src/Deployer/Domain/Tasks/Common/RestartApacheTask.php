<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common;

use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ApacheShell;

class RestartApacheTask extends BaseShell implements TaskInterface
{

    protected $title = 'Restart apache';

    public function run()
    {
        $apache = new ApacheShell($this->remoteShell);
        $apache->restart();
    }
}
