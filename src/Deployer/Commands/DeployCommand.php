<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Instance\Helpers\InstanceHelper;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerDeployShell;

class DeployCommand extends Command
{

    protected static $defaultName = 'deployer:server:deploy';
    private $io;

    protected function configure()
    {
        $this->addArgument('projectName', InputArgument::OPTIONAL);
        /*$this->addOption(
            'wrapped',
            null,
            InputOption::VALUE_OPTIONAL,
            '',
            false
        );*/
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer. Deploy</>']);

        $deployProfiles = ConfigProcessor::get('deployProfiles');
        
        $projectName = $input->getArgument('projectName');
        if(empty($projectName)) {
            $profiles = array_keys($deployProfiles);
            $projectName = $this->io->choiceQuestion('Select profile', $profiles);
        }

        $profileConfig = $deployProfiles[$projectName];
        $deployShell = $this->createShellInstance($profileConfig['handler']);
        $deployShell->run($projectName);

        $this->io->success('Success!');

        return Command::SUCCESS;
    }

    private function getProfileName(): string
    {
        
    }

    private function createShellInstance($shellDefinition)
    {
        $remoteShell = ShellFactory::create();
        //        $deployShell = new $shellDefinition($remoteShell, $this->io);
//        $deployShell = new DeployShell($remoteShell, $this->io);
        $deployShell = InstanceHelper::create($shellDefinition, [
            BaseShellNew::class => $remoteShell,
            IO::class => $this->io,
        ]);
        return $deployShell;
    }
}
