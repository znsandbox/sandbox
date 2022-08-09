<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\ShellNew\FileSystemShell;

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
        $dsn = $this->remoteShell->getHostEntity()->getDsn();
        $out = $this->localShell->runCommand("ssh-copy-id -i {$publicKeyFileName} {$dsn}");
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
