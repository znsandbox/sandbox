<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ApacheRestartTask extends BaseShell implements TaskInterface
{

    protected $title = 'Apache2 restart';
    
    public function run()
    {
//        $this->io->writeln(' ... ');
//        $this->run('sudo systemctl restart apache2');
        
        $apacheShell = new ApacheShell($this->remoteShell);
        $apacheShell->restart();
    }
}
