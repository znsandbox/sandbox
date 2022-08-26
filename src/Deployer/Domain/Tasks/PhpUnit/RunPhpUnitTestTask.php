<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\PhpUnit;

use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PhpUnitShell;

class RunPhpUnitTestTask extends BaseShell implements TaskInterface
{

    protected $title = 'PhpUnit. Run tests';
    public $profile;

    public function run()
    {
        $phpUnitShell = new PhpUnitShell($this->remoteShell);
        $phpUnitShell->setDirectory(VarProcessor::get('releasePath'));
        $out = $phpUnitShell->run();
        if(preg_match('/OK \((\d+) tests, (\d+) assertions\)/', $out, $matches)) {
            $res = [];
            $res['testCount'] = $matches[1];
            $res['assertCount'] = $matches[2];

            preg_match('/Time: (.+), Memory: (.+ \w+)/', $out, $matches);
            $res['time'] = $matches[1];
            $res['memory'] = $matches[2];

            $this->io->writelnListItem("testCount: {$res['testCount']}");
            $this->io->writelnListItem("assertCount: {$res['assertCount']}");
            $this->io->writelnListItem("time: {$res['time']}");
            $this->io->writelnListItem("memory: {$res['memory']}");
            $this->io->success('OK');
        } else {
            $this->io->error('Fail');
        }
    }
}
