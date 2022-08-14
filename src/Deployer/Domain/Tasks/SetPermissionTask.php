<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class SetPermissionTask extends BaseShell implements TaskInterface
{

    public $config;

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $this->io->writeln('set permission ... ');
        $this->setPermissions($profileName);
    }

    protected function setPermissions(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $fs = new FileSystemShell($this->remoteShell);
        if (isset($this->config)) {
            foreach ($this->config as $item) {
                $this->io->writeln("  set '{$item['permission']}' to '{$item['path']}' ... ");
                $fs->sudo()->chmod($item['path'], $item['permission'], true);
            }
        }
    }
}
