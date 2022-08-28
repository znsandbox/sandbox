<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConfigProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConnectionProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;

class SetSudoPasswordTask extends BaseShell implements TaskInterface
{

    public $password = null;
    protected $title = 'Set sudo password';

    public function run()
    {
//        $connectionName = VarProcessor::get('currentConnection', 'default');
//        $connection = ConfigProcessor::get('connections.' . $connectionName);

        $connection = ConnectionProcessor::getCurrent();
        $this->setSudoPassword($connection['password'] ?? null);
    }
    
    public function setSudoPassword(string $password = null)
    {
        if ($password == null) {
            $password = $this->io->askHiddenResponse('Input sudo password:');
        }
        $fs = new FileSystemShell($this->remoteShell);
        $fs->uploadContent($password, '~/sudo-pass');
    }
}
