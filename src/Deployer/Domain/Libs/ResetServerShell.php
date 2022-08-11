<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnLib\Console\Domain\ShellNew\FileSystemShell;
use ZnLib\Console\Domain\ShellNew\Legacy\ApacheShell;
use ZnLib\Console\Domain\ShellNew\Legacy\ComposerShell;
use ZnLib\Console\Domain\ShellNew\Legacy\HostsShell;
use ZnLib\Console\Domain\ShellNew\Legacy\VirtualBoxShell;
use ZnLib\Console\Domain\ShellNew\Legacy\ZipShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Shell\LocalShell;

class ResetServerShell extends BaseShell
{

    private $vmDirectory = '/home/vitaliy/VirtualBox VMs';
    private $vmName = 'Server';
    private $vmBackup = '/home/vitaliy/VirtualBox VMs/-backup/3_Server_upgraded_2022_08_11.zip';

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
    }

    public function run()
    {
//        dd('ResetServerShell');

        $this->io->writeln('shutDown ... ');
        $this->shutDown();

        $this->io->writeln('removeFiles ... ');
        $this->removeFiles();

        $this->io->writeln('restoreFromBackup ... ');
        $this->restoreFromBackup();

        $this->io->writeln('startUp ... ');
        $this->startUp();

        #cd "/home/vitaliy/VirtualBox VMs"
    }

    protected function shutDown()
    {
        #VBoxManage controlvm "Server" acpipowerbutton
        #sleep 5s
        $virtualBox = new VirtualBoxShell($this->localShell);
        $virtualBox->shutDown($this->vmName);
        $this->io->writeln('wait 10 seconds ... ');
        $this->localShell->runCommand("sleep 10s");
    }

    protected function removeFiles()
    {
        #rm -rf Server
        $fs = new FileSystemShell($this->remoteShell);
        $fs->sudo()->removeDir($this->vmDirectory);
//        $this->localShell->sudo()->runCommand("cd \"{$this->vmDirectory}\" && rm -rf \"{$this->vmName}\"");
    }

    protected function restoreFromBackup()
    {
        #unzip "/home/vitaliy/VirtualBox VMs/-backup/3_Server_upgraded_2022_08_11.zip"

        $zip = new ZipShell($this->remoteShell);
        $zip->unZipAllToDir($this->vmBackup, $this->vmDirectory);
        
//        $this->localShell->runCommand("cd \"{$this->vmDirectory}\" && unzip \"{$this->vmBackup}\"");
    }

    protected function startUp()
    {
        #VBoxManage startvm "Server" --type headless
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
