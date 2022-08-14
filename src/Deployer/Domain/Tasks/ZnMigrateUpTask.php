<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ZnMigrateUpTask extends BaseShell implements TaskInterface
{

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $envName = $profileConfig['env'];

        $this->io->writeln('zn migrate up ... ');
//        $this->migrateUp($profileConfig['env']);

        $zn = new ZnShell($this->remoteShell);
        $zn->setDirectory($profileConfig['release_path']);
        $zn->migrateUp($envName);

        /*try {
            $zn->migrateUp($envName);
        } catch (\Throwable $e) {
            $fs = new FileSystemShell($this->remoteShell);
            $fs->sudo()->chmod($profileConfig['release_path']. '/var', 'a+w', true);
            $zn->migrateUp($envName);
        }*/
    }

    protected function migrateUp(string $envName)
    {

    }
}
