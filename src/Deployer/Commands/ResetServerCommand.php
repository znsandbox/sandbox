<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Instance\Helpers\InstanceHelper;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnLib\Console\Domain\ShellNew\Legacy\ApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerDeployShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerLampApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ResetServerShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;

class ResetServerCommand extends Command
{

    protected static $defaultName = 'deployer:server:reset';
    
    /** @var IO */
    private $io;

    protected function configure()
    {
        $this->addArgument('projectName', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer. Reset server</>']);

        $remoteShell = ShellFactory::create();

        $resetServerShell = new ResetServerShell($remoteShell, $this->io);
        $resetServerShell->run();

        $this->io->success('Success!');

        return Command::SUCCESS;
    }
}
