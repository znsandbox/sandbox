<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\ConfigureServerLampApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\ConfigureServerLampComposerShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\ConfigureServerLampGitShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\ConfigureServerLampNpmShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\ConfigureServerLampPhpShell;

class ConfigureServerLampCommand extends Command
{

    protected static $defaultName = 'deployer:server:configureLamp';
    private $io;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $this->io = new IO($input, $output);

        $this->io->writeTitle('Deployer. Install LAMP');

//        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
        $remoteShell = ShellFactory::createRemoteShell();

        $serverLampGitShell = new ConfigureServerLampGitShell($remoteShell, $this->io);
        $serverLampGitShell->install();

        $serverLampApacheShell = new ConfigureServerLampApacheShell($remoteShell, $this->io);
        $serverLampApacheShell->install();
        $serverLampApacheShell->config();

        $serverLampPhpShell = new ConfigureServerLampPhpShell($remoteShell, $this->io);
        $serverLampPhpShell->install();
        $serverLampPhpShell->config();

        $serverLampComposerShell = new ConfigureServerLampComposerShell($remoteShell, $this->io);
        $serverLampComposerShell->install();
        $serverLampComposerShell->config();

        /*$serverLampNpmShell = new ConfigureServerLampNpmShell($remoteShell, $this->io);
        $serverLampNpmShell->install();
        $serverLampNpmShell->config();*/

        $output->writeln(['', '<fg=green>Success!</>', '']);

        return Command::SUCCESS;
    }
}