<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Services\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ComposerShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\GitShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\HostsShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZnShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;

class DeployZnShell extends BaseShell
{

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        VarProcessor::setList($profileConfig['vars']);

        $envName = $profileConfig['env'];

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

        $this->io->writeln('zn init ... ');
        $this->init($envName);

        $this->io->writeln('migrate up... ');
        $this->migrateUp($envName);

        $this->io->writeln('fixture import ... ');
        $this->fixtureImport($envName);
    }

    protected function clone(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $git = new GitShell($this->remoteShell);
        $git->setDirectory($profileConfig['directory']);

        $fs = new FileSystemShell($this->remoteShell);
        $fs->makeDirectory($profileConfig['directory']);
        if (!$fs->isDirectoryExists($profileConfig['directory'] . '/.git')) {
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
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $composer = new ComposerShell($this->remoteShell);
        $composer->install($profileConfig['directory']);
    }

    protected function updateDependency(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $composer = new ComposerShell($this->remoteShell);
        $composer->update($profileConfig['directory']);
    }

    protected function setPermissions(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $fs = new FileSystemShell($this->remoteShell);

        if (isset($profileConfig['writable'])) {
            foreach ($profileConfig['writable'] as $path) {
                $this->io->writeln("  set writable $path ... ");
                $fs->sudo()->chmod($path, 'a+w', true);
            }
        }
    }

    protected function assignDomains(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $apache = new ApacheShell($this->remoteShell);
        $hosts = new HostsShell($this->remoteShell);

        foreach ($profileConfig['domains'] as $item) {
            $domain = VarProcessor::process($item['domain']);
            $directory = VarProcessor::process($item['directory']);
            $hosts->add($domain);
            $apache->addConf($domain, $directory);
        }
    }

    protected function apacheRestart()
    {
        $apache = new ApacheShell($this->remoteShell);
        $apache->restart();
    }

    protected function init(string $envName)
    {
        $zn = new ZnShell($this->remoteShell);
        $zn->init($envName);
    }

    protected function migrateUp(string $envName)
    {
        $zn = new ZnShell($this->remoteShell);
        try {
            $zn->migrateUp($envName);
        } catch (\Throwable $e) {
            $fs = new FileSystemShell($this->remoteShell);
            $fs->sudo()->chmod('{{release_path}}/var', 'a+w', true);
            $zn->migrateUp($envName);
        }
    }

    protected function fixtureImport(string $envName)
    {
        $zn = new ZnShell($this->remoteShell);
        $zn->fixtureImport($envName);
    }
}
