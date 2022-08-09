<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\ShellNew\FileSystemShell;
use ZnLib\Console\Domain\ShellNew\Legacy\ComposerShell;
use ZnLib\Console\Domain\ShellNew\Legacy\GitShell;

class DeployShell extends BaseShell
{

    public function run(string $profileName)
    {
        $this->io->writeln('git clone ... ');
        $this->clone($profileName);

        $this->io->writeln('composer install ... ');
        $this->installDependency($profileName);
    }

    protected function clone(string $profileName)
    {
        $profileConfig = ConfigProcessor::get('deployProfiles.' . $profileName);
        $git = new GitShell($this->remoteShell);
        $git->setDirectory($profileConfig['directory']);

        $fs = new FileSystemShell($this->remoteShell);
        if( ! $fs->isDirectoryExists($profileConfig['directory'])) {
            $git->clone($profileConfig['git']['repository'], $profileConfig['git']['branch'] ?? null, $profileConfig['directory']);
        } else {
            $this->io->warning('repository already exists!');
            $this->io->writeln('git pull ...');
            $git->pull();
        }

        /*try {
            $git->clone($profileConfig['git']['repository'], $profileConfig['git']['branch'] ?? null, $profileConfig['directory']);
        } catch (\Throwable $e) {
            $this->io->writeSubTitle($e->getMessage());
        }*/
    }

    protected function installDependency(string $profileName)
    {
        $profileConfig = ConfigProcessor::get('deployProfiles.' . $profileName);
        $composer = new ComposerShell($this->remoteShell);
        $composer->install($profileConfig['directory']);
    }
}
