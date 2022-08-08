<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\IO;

class ConfigureServerSshCommand extends Command
{

    protected static $defaultName = 'deployer:server:configureSsh';
    private $io;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer</>']);

        $remoteShell = ShellFactory::create();
        $configureServerShell = new ConfigureServerShell($remoteShell, $this->io);

        $sshDir = '/home/common/var/www/tool/vm-workspace/ssh';

        $keys = [
            $sshDir . '/my-github',
            $sshDir . '/my-gitlab',
        ];
        $configureServerShell->copySshKeys($keys);

        $files = [
            $sshDir . '/config',
            $sshDir . '/known_hosts',
        ];
        $configureServerShell->copySshFiles($files);

        $output->writeln(['', '<fg=green>Success!</>', '']);
        
        return Command::SUCCESS;
    }
}
