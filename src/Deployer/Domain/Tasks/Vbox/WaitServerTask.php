<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox;

use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;
use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\VirtualBoxShell;

class WaitServerTask extends BaseShell implements TaskInterface
{

    protected $title = 'VirtualBox. Wait start server';
    public $action;

    public function run()
    {
        $this->io->write(' ');
        while ($this->check()) {
            $this->io->write('.');
            sleep(2);
        }
    }

    protected function check(): bool
    {
        $vbox = new VirtualBoxShell($this->remoteShell);
        if ($this->action == 'start') {
            return !$vbox->isStarted();
        } elseif ($this->action == 'shutdown') {
            return $vbox->isStarted();
        } else {
            throw new \Exception("Unknown action \"{$this->action}\"");
        }
    }
}
