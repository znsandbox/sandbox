<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\LinuxPackage;

use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PackageShell;
use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;

class AddPackageRepositoryTask extends BaseShell implements TaskInterface
{

    public $repository = null;
    protected $title = 'Add package repository "{{repository}}"';

    public function run()
    {
        $packageShell = new PackageShell($this->remoteShell);
        $packageShell->addRepository($this->repository);
    }
}
