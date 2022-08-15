<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class SetPermissionTask extends BaseShell implements TaskInterface
{

    public $config;

    public function run()
    {
//        $profileName = VarProcessor::get('currentProfile');
//        $profileConfig = ProfileRepository::findOneByName($profileName);

        $this->io->writeln('set permission ... ');
        $this->setPermissions();
    }

    protected function setPermissions()
    {
//        $profileConfig = ProfileRepository::findOneByName($profileName);
        $fs = new FileSystemShell($this->remoteShell);
        if (isset($this->config)) {
            foreach ($this->config as $item) {

                if(isset($item['permission'])) {
                    $this->io->writeln("  chmod '{$item['permission']}' to '{$item['path']}' ... ");
                    $fs->sudo()->chmod($item['path'], $item['permission'], true);
                }

                if(isset($item['owner'])) {
                    $this->io->writeln("  chown '{$item['owner']}' to '{$item['path']}' ... ");
                    $fs->sudo()->chown($item['path'], $item['owner'], true);
                }

            }
        }
    }
}
