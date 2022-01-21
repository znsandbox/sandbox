<?php

namespace ZnSandbox\Sandbox\Grabber\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;

class DomainCommand extends Command
{

    protected static $defaultName = 'grabber:queue:grab';
    private $queueService;

    public function __construct(?string $name = null, QueueServiceInterface $queueService)
    {
        parent::__construct($name);
        $this->queueService = $queueService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=white># Grabber Queue grab</>');

        $queueCollection = $this->queueService->allNew();
        foreach ($queueCollection as $queueEntity) {
            $output->write($queueEntity->getHash() . ' ... ');
            try {
                $this->queueService->runOne($queueEntity);
                $output->writeln('OK');
                sleep(1);
            } catch (\Exception $e) {
                $output->writeln('FAIL');
            }
        }

        /*$isRun = true;
        while($isRun) {
            $this->queueService->runAll();
            sleep(10);
        }*/

        return 0;
    }
}
