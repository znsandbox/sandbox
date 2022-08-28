<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnLib\Console\Domain\Libs\IO;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConfigProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConnectionProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\ConfigureServerAccessShell;

class ConfigureServerAccessCommand extends Command
{

    protected static $defaultName = 'deployer:server:configureAccess';
    private $io;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer. Configure access</>']);

        $remoteShell = ShellFactory::createRemoteShell();
        $configureServerShell = new ConfigureServerAccessShell($remoteShell, $this->io);

//        $connection = ConfigProcessor::get('connections.default');
//        $publicKeyFileName = ConfigProcessor::get('access.sshPublicKeyFile');

        $connection = ConnectionProcessor::getCurrent();
        $publicKeyFileName = $connection['sshPublicKeyFile'];

        $this->io->writeln('register SSH public key ... ');
        $configureServerShell->registerPublicKey($publicKeyFileName);

        $this->io->writeln('set sudo password ... ');
        $configureServerShell->setSudoPassword($connection['password'] ?? null);

        $output->writeln(['', '<fg=green>Success!</>', '']);

        return Command::SUCCESS;
    }
}
