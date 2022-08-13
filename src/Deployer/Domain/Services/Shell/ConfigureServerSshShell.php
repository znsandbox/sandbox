<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Services\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\SshShell;

class ConfigureServerSshShell extends BaseShell
{

    public function copySshKeys(array $list)
    {
        $this->io->writeln('copy SSH keys ... ');

        $fs = new FileSystemShell($this->remoteShell);
        $userDir = ConfigProcessor::get('connections.default.user');
        foreach ($list as $sourceFilename) {
            $destFilename = "/home/{$userDir}/.ssh/" . basename($sourceFilename);

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
        $this->io->writeln('copy SSH config ... ');

        $fs = new FileSystemShell($this->remoteShell);
        foreach ($list as $sourceFilename) {
            $destFilename = "~/.ssh/" . basename($sourceFilename);
            $fs->uploadFile($sourceFilename, $destFilename);
        }
    }
}
