<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\TaskProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ChainTask extends BaseShell implements TaskInterface
{

    public $tasks = [];

    public function run()
    {
        TaskProcessor::runTaskList($this->tasks);
    }
}
