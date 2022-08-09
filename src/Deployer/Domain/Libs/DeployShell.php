<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use Deployer\ServerFs;
use Deployer\ServerHosts;
use ZnLib\Console\Domain\ShellNew\FileSystemShell;
use ZnLib\Console\Domain\ShellNew\Legacy\ApacheShell;
use ZnLib\Console\Domain\ShellNew\Legacy\ComposerShell;
use ZnLib\Console\Domain\ShellNew\Legacy\GitShell;
use ZnLib\Console\Domain\ShellNew\Legacy\HostsShell;
use ZnLib\Console\Domain\ShellNew\Legacy\ZnShell;
use function Deployer\parse;

class DeployShell extends BaseShell
{

    public function run(string $profileName)
    {
        $this->io->writeln('git clone ... ');
        $this->clone($profileName);

        $this->io->writeln('composer install ... ');
        $this->installDependency($profileName);

        $this->io->writeln('set permissions ... ');
        $this->setPermissions($profileName);

        $this->io->writeln('assign domains ... ');
        $this->assignDomains($profileName);

        $this->io->writeln('apache2 restart ... ');
        $this->apacheRestart();

        /*$zn = new ZnShell($this->remoteShell);

        $profileConfig = ConfigProcessor::get('deployProfiles.' . $profileName);
        $envName = $profileConfig['env'];

        $this->io->writeln('zn init ... ');
        $zn->init($envName);

        $this->io->writeln('migrate up... ');
        $zn->migrateUp($envName);

        $this->io->writeln('fixture import ... ');
        $zn->fixtureImport($envName);*/
    }

    protected function apacheRestart() {
        $apache = new ApacheShell($this->remoteShell);
        $apache->restart();
    }

    protected function assignDomains(string $profileName) {
        $profileConfig = ConfigProcessor::get('deployProfiles.' . $profileName);
        $apache = new ApacheShell($this->remoteShell);
        $hosts = new HostsShell($this->remoteShell);

        foreach ($profileConfig['domains'] as $item) {
            $hosts->add($item['domain']);
            $apache->addConf($item['domain'], $item['directory']);
        }
    }

    protected function setPermissions(string $profileName) {
        $profileConfig = ConfigProcessor::get('deployProfiles.' . $profileName);

        $fs = new FileSystemShell($this->remoteShell);

        if(isset($profileConfig['writable'])) {
            foreach ($profileConfig['writable'] as $path) {
                $this->io->writeln("set writable $path ... ");
                $fs->sudo()->chmod($path, 'a+w', true);
            }
        }
    }

    protected function clone(string $profileName)
    {
        $profileConfig = ConfigProcessor::get('deployProfiles.' . $profileName);
        $git = new GitShell($this->remoteShell);
        $git->setDirectory($profileConfig['directory']);

        $fs = new FileSystemShell($this->remoteShell);
        $fs->makeDirectory($profileConfig['directory']);
        if( ! $fs->isDirectoryExists($profileConfig['directory'] . '/.git')) {
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
