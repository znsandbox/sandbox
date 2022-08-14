<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ComposerShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ComposerInstallTask extends BaseShell implements TaskInterface
{

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $this->io->writeln('composer install ... ');
        $this->installDependency($profileName);
    }

    protected function installDependency(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $composer = new ComposerShell($this->remoteShell);
        $composer->setDirectory($profileConfig['release_path']);
        $composer->install();
    }
}
