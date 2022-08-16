<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\App;

use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnCore\Text\Helpers\TemplateHelper;
use ZnSandbox\Sandbox\Deployer\Domain\Factories\ShellFactory;

class TaskProcessor
{

    use SingletonTrait;

    public static function runTaskList(array $tasks, $io): void
    {
        foreach ($tasks as $task) {
            $taskInstance = ShellFactory::createTask($task, $io);
            $title = $taskInstance->getTitle();
            if ($title) {
                $title = TemplateHelper::render($title, $task, '{{', '}}');
                $io->writeln($title);
            }
            $taskInstance->run();
        }
    }
}
