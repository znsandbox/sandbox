<?php

namespace ZnSandbox\Sandbox\Grabber\Commands;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Helpers\UrlHelper;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;

class QueueParseCommand extends Command
{

    protected static $defaultName = 'grabber:queue:parse';
    private $queueService;

    public function __construct(?string $name = null, QueueServiceInterface $walletService)
    {
        parent::__construct($name);
        $this->queueService = $walletService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=white># Grabber Queue parse</>');

        $isRun = true;
        $isEmpty = false;
        while ($isRun) {
            $queueCollection = $this->runAll($output);
            if (!$queueCollection->isEmpty()) {
                $output->writeln('Wait queue ...');
                sleep(3);
            }
        }

        return 0;
    }

    private function runAll(OutputInterface $output): Collection
    {
        $queueCollection = $this->queueService->allGrabed();
        if($queueCollection->isEmpty()) {
            return $queueCollection;
        }

        $output->writeln('New tasks ' . $queueCollection->count());
        foreach ($queueCollection as $queueEntity) {
            $this->runOne($output, $queueEntity);
        }
        return $queueCollection;
    }

    private function runOne(OutputInterface $output, QueueEntity $queueEntity)
    {
        $url = UrlHelper::forgeUrlByQueueEntity($queueEntity);
        $output->write($url . ' ... ');
        
        try {
            $this->queueService->parseOne($queueEntity);
            $output->writeln('<info>OK</info>');
//            sleep(1);
        } catch (\Exception $e) {
//            dd($queueEntity);
//            dd($e);
            $output->writeln('<error>FAIL</error>');
        }
    }
}
