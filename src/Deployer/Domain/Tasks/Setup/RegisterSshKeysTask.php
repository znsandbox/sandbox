<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\SshShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class RegisterSshKeysTask extends BaseShell implements TaskInterface
{

    public $password = null;

    public function run()
    {
//        $profileConfig = ProfileRepository::findOneByName($profileName);
        $this->io->writeln('RegisterSshKeys ... ');

        $this->copySshKeys(ConfigProcessor::get('ssh.copyKeys'));
        $this->copySshFiles(ConfigProcessor::get('ssh.copyFiles'));
    }


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
