<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class WaitTask extends BaseShell implements TaskInterface
{

    public $seconds = null;
    protected $title = 'Wait {{seconds}} sec.';

    public function run()
    {
        sleep($this->seconds);
    }
}
