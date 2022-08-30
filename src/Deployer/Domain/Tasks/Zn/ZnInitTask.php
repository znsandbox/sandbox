<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Zn;

use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;
use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;

class ZnInitTask extends BaseShell implements TaskInterface
{

    protected $title = 'Zn. Init env';
    public $profile;

    public function __construct(BaseShellNew $remoteShell, IO $io)
    {
        parent::__construct($remoteShell, $io);
    }

    public function run()
    {
        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory(ShellFactory::getVarProcessor()->get('releasePath'));
        $zn->init($this->profile);
    }
}
