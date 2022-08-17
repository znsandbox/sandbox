<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Zn;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class ZnReloadWebSocketFixtureTask extends BaseShell implements TaskInterface
{

    protected $title = 'Zn. Reload webSocket';
    public $env = null;

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $this->io->writeln('  zn reload webSocket ... ');
//        $this->fixtureImport($profileConfig['env']);

        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory(VarProcessor::get('releasePath'));

        $this->io->writeln('  zn stop webSocket ... ');
        $zn->stopWebSocket($this->env);

        $this->io->writeln('  zn start webSocket ... ');
        $zn->startWebSocket($this->env);
    }
}
