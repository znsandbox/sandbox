<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\ConfigureServerSshShell;

class ConfigureServerSshCommand extends Command
{

    protected static $defaultName = 'deployer:server:configureSsh';
    private $io;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer. Configure SSH </>']);

        $remoteShell = ShellFactory::createRemoteShell();
        $configureServerShell = new ConfigureServerSshShell($remoteShell, $this->io);

        $configureServerShell->copySshKeys(ShellFactory::getConfigProcessor()->get('ssh.copyKeys'));
        $configureServerShell->copySshFiles(ShellFactory::getConfigProcessor()->get('ssh.copyFiles'));

//        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
//        $configureServerShell->copySshKeys($config['ssh']['copyKeys']);
//        $configureServerShell->copySshFiles($config['ssh']['copyFiles']);

        $output->writeln(['', '<fg=green>Success!</>', '']);

        return Command::SUCCESS;
    }
}
