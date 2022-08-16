<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Instance\Helpers\InstanceHelper;
use ZnCore\Text\Helpers\TemplateHelper;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\TaskProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerDeployShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ComposerInstallTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ConfigureDomainTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\GitCloneTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\RestartApacheTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\SetPermissionTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ZnImportFixtureTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ZnInitTask;
use ZnSandbox\Sandbox\Deployer\Domain\Tasks\ZnMigrateUpTask;

class DeployCommand extends Command
{

    protected static $defaultName = 'deployer:server:deploy';

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

        $output->writeln(['<fg=white># Deployer. Deploy</>']);

        $profileNames = $this->getProfileNames();

        foreach ($profileNames as $profileName) {
            $output->writeln(['', "<fg=blue>## Action $profileName</>", '']);
            $profileConfig = ProfileRepository::findOneByName($profileName);
            VarProcessor::setList($profileConfig['vars'] ?? []);
            VarProcessor::set('currentProfile', $profileName);
            $tasks = $profileConfig['tasks'];
            TaskProcessor::runTaskList($tasks, $this->io);
        }

        /*foreach ($tasks as $task) {
//            $taskInstance = $this->createShellInstance($task);
            $taskInstance = ShellFactory::createTask($task, $this->io);
            $title = $taskInstance->getTitle();
            if($title) {
                $title = TemplateHelper::render($title, $task, '{{', '}}');
                $this->io->writeln($title);
            }
            $taskInstance->run();
        }*/

//        foreach ($profileConfig['handlers'] as $handler) {
//            $deployShell = $this->createShellInstance($handler);
//            $deployShell->run($projectName);
//        }

        $this->io->success('Success!');

        return Command::SUCCESS;
    }

    private function getProfileNames(): array
    {
//        $deployProfiles = ConfigProcessor::get('deployProfiles');
        $projectName = $this->io->getInput()->getArgument('projectName');
        if (empty($projectName)) {
            $deployProfiles = ProfileRepository::findAll();
            $profiles = array_keys($deployProfiles);
            $projectNames = $this->io->multiChoiceQuestion('Select profiles', $profiles);
        } else {
            $projectNames = [$projectName];
        }
        return $projectNames;
    }

    /*private function createShellInstance($shellDefinition): TaskInterface
    {
        $remoteShell = ShellFactory::createRemoteShell();
        //        $deployShell = new $shellDefinition($remoteShell, $this->io);
//        $deployShell = new DeployShell($remoteShell, $this->io);
        $deployShell = InstanceHelper::create($shellDefinition, [
            BaseShellNew::class => $remoteShell,
            IO::class => $this->io,
        ]);
        return $deployShell;
    }*/
}
