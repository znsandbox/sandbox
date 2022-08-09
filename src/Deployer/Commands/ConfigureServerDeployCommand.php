<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Instance\Helpers\InstanceHelper;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnLib\Console\Symfony4\Question\ChoiceQuestion;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerAccessShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerDeployShell;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\DeployShell;

class ConfigureServerDeployCommand extends Command
{

    protected static $defaultName = 'deployer:server:deploy';
    private $io;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer. Deploy</>']);

        $deployProfiles = ConfigProcessor::get('deployProfiles');
        $profiles = array_keys($deployProfiles);

        $output->writeln('');
        $question = new ChoiceQuestion(
            'Select profile',
            $profiles
        );
        $selectedIndex = $this->getHelper('question')->ask($input, $output, $question);

        $remoteShell = ShellFactory::create();

        $profileConfig = ConfigProcessor::get('deployProfiles.' . $selectedIndex);
        $shellDefinition = $profileConfig['class'];
//        $deployShell = new $shellDefinition($remoteShell, $this->io);
        $deployShell = InstanceHelper::create($shellDefinition, [
            BaseShellNew::class => $remoteShell,
            IO::class => $this->io,
        ]);
//        $deployShell = new DeployShell($remoteShell, $this->io);
        $deployShell->run($selectedIndex);

        $output->writeln(['', '<fg=green>Success!</>', '']);
        
        return Command::SUCCESS;
    }
}
