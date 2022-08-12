<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use Deployer\Deployer;
use Deployer\ServerFs;
use Deployer\Task\Context;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use ZnCore\FileSystem\Helpers\FindFileHelper;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\FileSystemShell;
use ZnLib\Console\Symfony4\Helpers\InputHelper;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\SshShell;
use ZnSandbox\Sandbox\Deployer\Domain\Shell\LocalShell;

class _________ConfigureServerShell
{

    private $localShell;
    private $remoteShell;
//    private $input;
//    private $output;
    private $io;

    public function __construct(BaseShellNew $remoteShell, IO $io)
    {
        $this->localShell = new LocalShell();
        $this->remoteShell = $remoteShell;
//        $this->input = $io->getInput();
//        $this->output  = $io->getOutput();
//        $this->io = new IO($input, $output);
        $this->io = $io;
    }

    public function sshList()
    {
        $output = $this->remoteShell->runCommand('ssh-add -l');
        return explode(PHP_EOL, trim($output));
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

    public function setSudoPassword(string $password = null)
    {
        if($password == null) {
            $password = askHiddenResponse('Input sudo password:');
        }
        $fs = new FileSystemShell($this->remoteShell);
        $fs->uploadContent($password, '~/sudo-pass');
    }

    public function registerPublicKey(string $publicKeyFileName)
    {
        $fs = new FileSystemShell($this->remoteShell);
        $file = '/home/user/111.txt';

//        dd($this->io->ask('qwerty'));

//        $fs->touch('/home/user/111.txt');
//        dd($fs->isFileExists('/etc/hosts'));
//        $fs->removeFile($file);
//        dd($fs->isFileExists($file));

        $dir = '/home/user/111';
//        $fs->makeDirectory($dir);
//        $fs->uploadFile('/home/common/var/www/social/server.soc/vendor/zntool/deployer/src/recipe/app/settings.php', $file);
//        $fs->uploadContent('qwerty123', $file);
//        dd($fs->downloadContent($file));
//        $fs->downloadFile($file, '/home/vitaliy/111111111111111111111111111111111');

//        dd(33);

//        dd($fs->isDirectoryExists($dir));


//        dd($fs->directoryFiles('/home/user/.ssh'));
//        dd($fs->directoryFiles('/home/user/.ssh/authorized_keys'));
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
