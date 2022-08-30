<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Code\Helpers\DeprecateHelper;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;
use ZnLib\Components\ShellRobot\Domain\Libs\App\TaskProcessor;
use ZnLib\Components\ShellRobot\Domain\Repositories\Config\ProfileRepository;
use ZnLib\Components\ShellRobot\Domain\Services\TaskService;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerDeployShell;

class DeployCommand extends Command
{

    protected static $defaultName = 'deployer:run';

    /** @var IO */
    private $io;

    private $taskService;

    public function __construct(string $name = null, TaskService $taskService)
    {
        parent::__construct($name);
        $this->taskService = $taskService;
    }

    protected function configure()
    {
        $this->addArgument('projectName', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        DeprecateHelper::hardThrow();

        set_time_limit(0);
        $this->io = new IO($input, $output);

        $output->writeln(['<fg=white># Deployer. Deploy</>']);

        $profileNames = $this->getProfileNames();
        foreach ($profileNames as $profileName) {
            $profileConfig = ProfileRepository::findOneByName($profileName);
            $output->writeln(['', "<fg=blue>## {$profileConfig['title']}</>", '']);
            $this->taskService->run($profileName, $this->io);

            /*ShellFactory::getVarProcessor()->setList($profileConfig['vars'] ?? []);
            ShellFactory::getVarProcessor()->set('currentProfile', $profileName);
            $tasks = $profileConfig['tasks'];
            TaskProcessor::runTaskList($tasks, $this->io);*/
        }
        $this->io->success('Success!');

        return Command::SUCCESS;
    }

    private function getProfileNames(): array
    {
        $projectName = $this->io->getInput()->getArgument('projectName');
        if (empty($projectName)) {
//            $deployProfiles = ProfileRepository::findAll();
            $profiles = ArrayHelper::getColumn($deployProfiles, 'title');
            $projectNames = $this->io->multiChoiceQuestion('Select profiles', $profiles);
        } else {
            $projectNames = [
                $projectName
            ];
        }
        return $projectNames;
    }
}
