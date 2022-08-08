<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerShell;

class ConfigureServerCommand extends Command
{

    protected static $defaultName = 'deployer:server:configure';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['<fg=white># Deployer</>']);

        $remoteShell = ShellFactory::create();
        $configureServerShell = new ConfigureServerShell($remoteShell);

//        dd($configureServerShell->fileList('~/.ssh'));
        
        $publicKeyFileName = '~/.ssh/ubuntu-server.pub';
//        $out = $remoteShell->runCommand("cat {$publicKeyFileName} | ssh {$host->getDsn()} \"mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys\"");
//        $configureServerShell->uploadPublicKey($publicKeyFileName);
//        $configureServerShell->copyId($publicKeyFileName);
        $configureServerShell->registerPublicKey($publicKeyFileName);
        
//        'ssh-copy-id -i ~/.ssh/ubuntu-server.pub ssh://user@localhost:2222';

//        $out = $remoteShell->runRemoteCommand('ls -l');
//        dd($out);

        $output->writeln(['', '<fg=green>Success!</>', '']);
        
        return Command::SUCCESS;
    }
}
