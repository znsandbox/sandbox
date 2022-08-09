<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\ShellNew\Legacy\ComposerShell;
use ZnLib\Console\Domain\ShellNew\Legacy\GitShell;

class DeployShell extends BaseShell
{

    public function run(string $profileName)
    {
        $this->clone($profileName);
        $this->installDependency($profileName);
    }

    protected function clone(string $profileName)
    {
        $profileConfig = ConfigProcessor::get('deployProfiles.' . $profileName);
        $git = new GitShell($this->remoteShell);
        $this->io->writeln('git clone');
        try {
            $git->clone($profileConfig['git']['repository'], $profileConfig['git']['branch'] ?? null, $profileConfig['directory']);
        } catch (\Throwable $e) {
            $this->io->writeSubTitle($e->getMessage());
        }
    }

    protected function installDependency(string $profileName)
    {
        $profileConfig = ConfigProcessor::get('deployProfiles.' . $profileName);
        $composer = new ComposerShell($this->remoteShell);
        $this->io->writeln('composer install');
        $composer->install($profileConfig['directory']);
    }
}
