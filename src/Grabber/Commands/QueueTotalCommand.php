<?php

namespace ZnSandbox\Sandbox\Grabber\Commands;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\QueueEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;

class QueueTotalCommand extends Command
{

    protected static $defaultName = 'grabber:queue:total';
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
            $totalDto = $this->queueService->total();
            $output->write(sprintf("\033\143"));
            $output->writeln('');
            $output->writeln('## Total (' . date('Y.m.d H:i:s') . ')');
            $output->writeln('All: ' . $totalDto->getAll());
            $output->writeln('New: ' . $totalDto->getNew());
            $output->writeln('Grabed: ' . $totalDto->getGrabed());
            $output->writeln('Parsed: ' . $totalDto->getParsed());
            $output->writeln('Wait 3 second ...');

            sleep(1);
            // выводить кол-во страниц продуктов, общее, 90, 200, 210
        }

        return 0;
    }
}
