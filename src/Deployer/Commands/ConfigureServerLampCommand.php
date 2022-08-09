<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerLampShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerSshShell;

class ConfigureServerLampCommand extends Command
{

    protected static $defaultName = 'deployer:server:configureLamp';
    private $io;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer. Configure SSH </>']);

        $remoteShell = ShellFactory::create();
        $configureServerShell = new ConfigureServerLampShell($remoteShell, $this->io);

        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);

        $configureServerShell->installApache();

        $output->writeln(['', '<fg=green>Success!</>', '']);
        
        return Command::SUCCESS;
    }
}
