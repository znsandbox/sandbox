<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common;

use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\TaskProcessor;
use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;

class ChainTask extends BaseShell implements TaskInterface
{

    public $tasks = [];

    public function run()
    {
        TaskProcessor::runTaskList($this->tasks);
    }
}
