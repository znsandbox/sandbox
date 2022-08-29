<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Arr\Helpers\ArrayHelper;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConfigProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\App\TaskProcessor;
use ZnLib\Components\ShellRobot\Domain\Repositories\Config\ProfileRepository;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerDeployShell;

class DeployCommand extends Command
{

    protected static $defaultName = 'deployer:run';

    /** @var IO */
    private $io;

    protected function configure()
    {
        $this->addArgument('projectName', InputArgument::OPTIONAL);
    }

    /*private function initApp()
    {
        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
        $vars = $config['vars'];
        $vars['userName'] = $config['connections']['default']['user'];
        $vars['homeUserDir'] = "/home/{$vars['userName']}";
//        ConfigProcessor::getInstance()->setConfig($config);
//        ShellFactory::getVarProcessor()->setVars($vars);
    }*/

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);
        $this->io = new IO($input, $output);

//        $this->initApp();

        $output->writeln(['<fg=white># Deployer. Deploy</>']);

        $profileNames = $this->getProfileNames();
        foreach ($profileNames as $profileName) {
            $profileConfig = ProfileRepository::findOneByName($profileName);
            $output->writeln(['', "<fg=blue>## {$profileConfig['title']}</>", '']);
            ShellFactory::getVarProcessor()->setList($profileConfig['vars'] ?? []);
            ShellFactory::getVarProcessor()->set('currentProfile', $profileName);
            $tasks = $profileConfig['tasks'];
            TaskProcessor::runTaskList($tasks, $this->io);
        }
        $this->io->success('Success!');

        return Command::SUCCESS;
    }

    private function getProfileNames(): array
    {
        $projectName = $this->io->getInput()->getArgument('projectName');
        if (empty($projectName)) {
            $deployProfiles = ProfileRepository::findAll();
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
