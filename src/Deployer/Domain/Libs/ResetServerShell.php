<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\ApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\ComposerShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\HostsShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\VirtualBoxShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\ZipShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Shell\LocalShell;

class ResetServerShell extends BaseShell
{

    private $vmDirectory;
    private $vmName;
    private $vmBackup;

    /*public function __construct(BaseShellNew $remoteShell, IO $io)
    {
        $remoteShell = new LocalShell();
        parent::__construct($remoteShell, $io);
    }*/

    public function __construct(BaseShellNew $remoteShell, IO $io)
    {
        $this->localShell = new LocalShell();
        $this->remoteShell = new LocalShell();
        $this->io = $io;

        $this->vmName = $_ENV['DEPLOYER_VIRTUAL_BOX_NAME'];
        $this->vmDirectory = $_ENV['DEPLOYER_VIRTUAL_BOX_DIRECTORY'];
        $this->vmBackup = $_ENV['DEPLOYER_VIRTUAL_BOX_BACKUP_FILE'];
    }

    public function run()
    {
        $this->io->writeln('shutDown server  ... ');
        $this->shutDown();

        $this->io->writeln('remove VirtualBox image ... ');
        $this->removeFiles();

        $this->io->writeln('restore VirtualBox image from backup ... ');
        $this->restoreFromBackup();

        $this->io->writeln('startUp ... ');
        $this->startUp();
    }

    protected function shutDown()
    {
        $virtualBox = new VirtualBoxShell($this->localShell);
        $virtualBox->shutDown($this->vmName);
        $seconds = 5;
        $this->io->writeln("wait $seconds seconds ... ");
        $this->localShell->runCommand("sleep {$seconds}s");
    }

    protected function removeFiles()
    {
        $fs = new FileSystemShell($this->remoteShell);
        $fs->sudo()->removeDir($this->vmDirectory . '/' . $this->vmName);
    }

    protected function restoreFromBackup()
    {
        $zip = new ZipShell($this->remoteShell);
        $zip->unZipAllToDir($this->vmBackup, $this->vmDirectory);
    }

    protected function startUp()
    {
        $virtualBox = new VirtualBoxShell($this->localShell);
        $virtualBox->startUp($this->vmName);
    }

    protected function assignDomains(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $apache = new ApacheShell($this->remoteShell);
        $hosts = new HostsShell($this->remoteShell);

        foreach ($profileConfig['domains'] as $item) {
            $hosts->add($item['domain']);
            $apache->addConf($item['domain'], $item['directory']);
        }
    }

    protected function setPermissions(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $fs = new FileSystemShell($this->remoteShell);

        if (isset($profileConfig['writable'])) {
            foreach ($profileConfig['writable'] as $path) {
                $this->io->writeln("set writable $path ... ");
                $fs->sudo()->chmod($path, 'a+w', true);
            }
        }
    }

    protected function clone(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $virtualBoxShell = new VirtualBoxShell($this->remoteShell);
        $virtualBoxShell->setDirectory($profileConfig['directory']);

        $fs = new FileSystemShell($this->remoteShell);
        $fs->makeDirectory($profileConfig['directory']);
        if (!$fs->isDirectoryExists($profileConfig['directory'] . '/.git')) {
            $virtualBoxShell->clone($profileConfig['git']['repository'], $profileConfig['git']['branch'] ?? null, $profileConfig['directory']);
        } else {
            $this->io->warning('repository already exists!');
            $this->io->writeln('git pull ...');
            $virtualBoxShell->pull();
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
}
