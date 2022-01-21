<?php

namespace ZnSandbox\Sandbox\Grabber\Commands;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;

class QueueGrabCommand extends Command
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

        $isRun = true;
        $isEmpty = false;
        while ($isRun) {
            $queueCollection = $this->runAll($output);
            if ($queueCollection->isEmpty()) {
                /*if(!$isEmpty) {
                    $output->writeln('wait ');
                    $isEmpty = true;
                }
                if($isEmpty) {
                    $output->write('.');
                }*/
            }
//            sleep(1);
            usleep(200);
        }

        return 0;
    }

    private function runAll(OutputInterface $output): Collection
    {
        $queueCollection = $this->queueService->allNew();
        foreach ($queueCollection as $queueEntity) {
            $this->runOne($output, $queueEntity);
        }
        return $queueCollection;
    }

    private function runOne(OutputInterface $output, QueueEntity $queueEntity)
    {
        $output->write($queueEntity->getHash() . ' ... ');
        try {
            $this->queueService->runOne($queueEntity);
            $output->writeln('OK');
            sleep(1);
        } catch (\Exception $e) {
            $output->writeln('FAIL');
        }
    }
}
