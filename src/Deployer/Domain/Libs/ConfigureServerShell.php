<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnSandbox\Sandbox\Deployer\Domain\Shell\LocalShell;

class ConfigureServerShell
{

    private $localShell;
    private $remoteShell;

    public function __construct(BaseShellNew $remoteShell)
    {
        $this->localShell = new LocalShell();
        $this->remoteShell = $remoteShell;
    }

    public function registerPublicKey(string $publicKeyFileName)
    {
//        dd($this->remoteShell->runCommand('cd ~/.ssh && ls -l'));
        
        $this->uploadPublicKey($publicKeyFileName);
        $this->copyId($publicKeyFileName);
    }
    
    private function copyId(string $publicKeyFileName)
    {
        $dsn = $this->remoteShell->getHostEntity()->getDsn();
        $out = $this->localShell->runCommand("ssh-copy-id -i {$publicKeyFileName} {$dsn}");
        if(trim($out) != null) {
            throw new \Exception('copyId error! ' . $out);
        }
        return $out;
    }
    
    private function uploadPublicKey(string $publicKeyFileName)
    {
        $sshCommand = $this->remoteShell->wrapCommand("mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys");
        $out = $this->localShell->runCommand("cat {$publicKeyFileName} | {$sshCommand}");
        if(trim($out) != null) {
            throw new \Exception('uploadPublicKey error! ' . $out);
        }
        return $out;
    }
}
