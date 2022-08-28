<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common;

use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;

class WaitTask extends BaseShell implements TaskInterface
{

    public $seconds = null;
    protected $title = 'Wait {{seconds}} sec.';

    public function run()
    {
        sleep($this->seconds);
    }
}
