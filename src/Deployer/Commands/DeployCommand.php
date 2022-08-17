<?php

namespace ZnSandbox\Sandbox\Deployer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Arr\Helpers\ArrayHelper;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\TaskProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ConfigureServerDeployShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;

class DeployCommand extends Command
{

    protected static $defaultName = 'deployer:run';

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

        $this->io->success('Success!');

        return Command::SUCCESS;
    }

    private function getProfileNames(): array
    {
        $projectName = $this->io->getInput()->getArgument('projectName');
        if (empty($projectName)) {
            $deployProfiles = ProfileRepository::findAll();
//            $profiles = array_keys($deployProfiles);
            $profiles = ArrayHelper::getColumn($deployProfiles, 'title');
//            dd($profiles);



//            $profilesIndexed = array_keys($profiles);
//            $titleIndexed = array_values($profiles);
            $projectNames = $this->io->multiChoiceQuestion('Select profiles', $profiles);

//            dd($projectNames);

            /*$new = [];
            foreach ($titleIndexed as $index => $title) {
                if(in_array($title, $selected)) {
                    $new[] = $profilesIndexed[$index];
                }
            }

            dd($new);*/
        } else {
            $projectNames = [
                $projectName
            ];
        }
        return $projectNames;
    }
}
