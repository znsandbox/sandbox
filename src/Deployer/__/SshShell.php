<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Shell;

//use ZnCore\Code\Helpers\DeprecateHelper;
//use ZnLib\Console\Domain\Base\BaseShellNew;
//use ZnLib\Console\Domain\Helpers\CommandLineHelper;
//use ZnSandbox\Sandbox\Deployer\Domain\Entities\HostEntity;
//
//DeprecateHelper::hardThrow();
//
//class SshShell extends BaseShellNew
//{
//
//    private $hostEntity;
//
//    public function __construct(HostEntity $hostEntity)
//    {
//        $this->hostEntity = $hostEntity;
//    }
//
//    public function getHostEntity(): HostEntity
//    {
//        return $this->hostEntity;
//    }
//
//    public function wrapCommand($command): string
//    {
//        $command = CommandLineHelper::argsToString($command, $this->lang);
//        $command = escapeshellarg($command);
////        $sshDsn = "{$this->hostEntity->getUser()}@{$this->hostEntity->getHost()}:{$this->hostEntity->getPort()}";
//        $host = $this->hostEntity->getDsn();
//        // ssh  ssh://user@localhost:2222
//        return "ssh $host $command";
//    }
//
//    public function runCommand($command, ?string $path = null): string 
//    {
//        $ssh = $this->wrapCommand($command);
//        $commandOutput = parent::runCommand($ssh);
//        return $commandOutput;
//    }
//
//    /*public function copyId(string $publicKeyFileName)
//    {
//        $out = $this->runCommand("ssh-copy-id -i {$publicKeyFileName} {$this->hostEntity->getDsn()}");
//        if(trim($out) != null) {
//            throw new \Exception('copyId error! ' . $out);
//        }
//        return $out;
//    }
//    
//    public function uploadPublicKey(string $publicKeyFileName)
//    {
//        $out = $this->runCommand("cat {$publicKeyFileName} | ssh {$this->hostEntity->getDsn()} \"mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys\"");
//        if(trim($out) != null) {
//            throw new \Exception('uploadPublicKey error! ' . $out);
//        }
//        return $out;
//    }*/
//
//    /*public function fileList(string $path)
//    {
//        $commandOutput = $this->runCommand( 'ls -l');
//        dd($commandOutput);
//    }*/
//}
