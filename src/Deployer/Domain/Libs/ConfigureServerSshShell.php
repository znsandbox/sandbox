<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnLib\Console\Domain\ShellNew\FileSystemShell;
use ZnLib\Console\Domain\ShellNew\SshShell;
use ZnSandbox\Sandbox\Deployer\Domain\Shell\LocalShell;

class ConfigureServerSshShell
{

    private $localShell;
    private $remoteShell;
    private $io;

    public function __construct(BaseShellNew $remoteShell, IO $io)
    {
        $this->localShell = new LocalShell();
        $this->remoteShell = $remoteShell;
        $this->io = $io;
    }

    public function copySshKeys(array $list)
    {
        $fs = new FileSystemShell($this->remoteShell);
        foreach ($list as $sourceFilename) {
            $destFilename = "~/.ssh/" . basename($sourceFilename);

            $fs->uploadFile($sourceFilename . '.pub', $destFilename . '.pub');
            $fs->chmod($destFilename . '.pub', '=644');

            $fs->uploadFile($sourceFilename, $destFilename);
            $fs->chmod($destFilename, '=600');
            $sshShell = new SshShell($this->remoteShell);
            $sshShell->add($destFilename);
        }
    }

    public function copySshFiles(array $list)
    {
        $fs = new FileSystemShell($this->remoteShell);
        foreach ($list as $sourceFilename) {
            $destFilename = "~/.ssh/" . basename($sourceFilename);
            $fs->uploadFile($sourceFilename, $destFilename);
        }
    }
}
