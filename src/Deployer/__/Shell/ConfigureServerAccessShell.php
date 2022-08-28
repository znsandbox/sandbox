<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Services\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnLib\Components\ShellRobot\Domain\Entities\HostEntity;

class ConfigureServerAccessShell extends BaseShell
{

    public function setSudoPassword(string $password = null)
    {
        if ($password == null) {
            $password = $this->io->askHiddenResponse('Input sudo password:');
        }
        $fs = new FileSystemShell($this->remoteShell);
        $fs->uploadContent($password, '~/sudo-pass');
    }

    public function registerPublicKey(string $publicKeyFileName)
    {
        $fs = new FileSystemShell($this->remoteShell);
        $this->uploadPublicKey($publicKeyFileName);
        $this->copyId($publicKeyFileName);
    }

    private function copyId(string $publicKeyFileName)
    {
        /** @var HostEntity $hostEntity */
        $hostEntity = $this->remoteShell->getHostEntity();
        $port = $hostEntity->getPort();
//        $dsn = $hostEntity->getDsn();

        $host = "{$hostEntity->getUser()}@{$hostEntity->getHost()}";
        $dsn = "-p $port $host";
        $cmd = "ssh-copy-id -i {$publicKeyFileName} {$dsn}";

        $out = $this->localShell->runCommand($cmd);

        if (trim($out) != null) {

            throw new \Exception('copyId error! ' . $out);
        }
        return $out;
    }

    private function uploadPublicKey(string $publicKeyFileName)
    {
//        $fs = new FileSystemShell($this->remoteShell);
//        $fs->makeDirectory('~/.ssh');
//        $fs->uploadFile($publicKeyFileName, '~/.ssh/authorized_keys');

        $sshCommand = $this->remoteShell->wrapCommand("mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys");
        $out = $this->localShell->runCommand("cat {$publicKeyFileName} | {$sshCommand}");
        if (trim($out) != null) {
            throw new \Exception('uploadPublicKey error! ' . $out);
        }
        return $out;
    }
}
