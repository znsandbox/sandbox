<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Vbox;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\Shell\LocalShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\VirtualBoxShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ZipShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class StartServerTask extends BaseShell implements TaskInterface
{

    public $password = null;
    protected $title = 'VirtualBox. Start server';

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
        /*$this->io->writeln('shutDown server  ... ');
        $this->shutDown();

        $this->io->writeln('remove VirtualBox image ... ');
        $this->removeFiles();

        $this->io->writeln('restore VirtualBox image from backup ... ');
        $this->restoreFromBackup();*/

//        $this->io->writeln('startUp server ... ');
        $this->startUp();
    }

    protected function shutDown()
    {
        $virtualBox = new VirtualBoxShell($this->localShell);
        $virtualBox->shutDown($this->vmName);
        $seconds = 5;
        $this->io->writeln("   wait $seconds seconds ... ");
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

        $seconds = 20;
        $this->io->writeln("wait $seconds seconds ... ");
        $this->localShell->runCommand("sleep {$seconds}s");
    }
}
