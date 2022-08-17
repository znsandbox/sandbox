<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class ZnMigrateUpTask extends BaseShell implements TaskInterface
{

    protected $title = 'ZN migrate up';
    public $env = null;

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory(VarProcessor::get('releasePath'));
        $zn->migrateUp($this->env);

        /*try {
            $zn->migrateUp($envName);
        } catch (\Throwable $e) {
            $fs = new FileSystemShell($this->remoteShell);
            $fs->sudo()->chmod($profileConfig['releasePath']. '/var', 'a+w', true);
            $zn->migrateUp($envName);
        }*/
    }

    protected function migrateUp(string $envName)
    {

    }
}
