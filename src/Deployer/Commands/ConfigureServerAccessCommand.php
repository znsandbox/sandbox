<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\IO;

class ConfigureServerAccessCommand extends Command
{

    protected static $defaultName = 'deployer:server:configureAccess';
    private $io;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer</>']);

        $remoteShell = ShellFactory::create();
        $configureServerShell = new ConfigureServerShell($remoteShell, $this->io);

        $publicKeyFileName = '~/.ssh/ubuntu-server.pub';
        $configureServerShell->setSudoPassword('111');
        $configureServerShell->registerPublicKey($publicKeyFileName);

        $output->writeln(['', '<fg=green>Success!</>', '']);
        
        return Command::SUCCESS;
    }
}
