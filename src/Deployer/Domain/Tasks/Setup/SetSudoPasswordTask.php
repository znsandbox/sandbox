<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConnectionProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

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
