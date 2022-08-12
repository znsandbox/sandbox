<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerAccessShell;

class ConfigureServerAccessCommand extends Command
{

    protected static $defaultName = 'deployer:server:configureAccess';
    private $io;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer. Configure access</>']);

        $remoteShell = ShellFactory::create();
        $configureServerShell = new ConfigureServerAccessShell($remoteShell, $this->io);

        $connection = ConfigProcessor::get('connections.default');
        $publicKeyFileName = ConfigProcessor::get('access.sshPublicKeyFile');

//        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
//        $connection = $config['connections']['default'];
//        $publicKeyFileName = $config['access']['sshPublicKeyFile'];

        $this->io->writeln('register SSH public key ... ');
        $configureServerShell->registerPublicKey($publicKeyFileName);

        $this->io->writeln('set sudo password ... ');
        $configureServerShell->setSudoPassword($connection['password'] ?? null);

        $output->writeln(['', '<fg=green>Success!</>', '']);

        return Command::SUCCESS;
    }
}
