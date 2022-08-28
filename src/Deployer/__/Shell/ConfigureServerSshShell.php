<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Services\Shell;

use ZnLib\Components\ShellRobot\Domain\Libs\App\ConfigProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConnectionProcessor;
use ZnLib\Components\ShellRobot\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\SshShell;

class ConfigureServerSshShell extends BaseShell
{

    public function copySshKeys(array $list)
    {
        $this->io->writeln('copy SSH keys ... ');

        $fs = new FileSystemShell($this->remoteShell);

        $connection = ConnectionProcessor::getCurrent();
        $userDir = $connection['user'];

//        $userDir = ConfigProcessor::get('connections.default.user');

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
