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
        date_default_timezone_set('Asia/Almaty');

        $sleepTime = 1;
        $isRun = true;
        $isEmpty = false;
        $lastUpdateTimePersist = null;
        while ($isRun) {
            $totalDto = $this->queueService->total();
            $lastUpdateTime = $this->queueService->lastUpdateTime();
            $now = new \DateTime('now');
//            $now->setTimezone($lastUpdateTime->getTimezone());
            $seconds = abs($now->getTimestamp() - $lastUpdateTime->getTimestamp());



            $isActive = $seconds < 5;
//            $isActive = $lastUpdateTimePersist && $lastUpdateTime - $lastUpdateTimePersist;
            $lastUpdateTimePersist = $lastUpdateTime;

            $output->write(sprintf("\033\143"));
            $output->writeln('');
            $output->writeln('## Total');
            $output->writeln('');
            $output->writeln('All: ' . $totalDto->getAll());
            $output->writeln('New: ' . $totalDto->getNew());
            $output->writeln('Grabed: ' . $totalDto->getGrabed());
            $output->writeln('Parsed: ' . $totalDto->getParsed());
            $output->writeln('');
            $output->writeln('Time: ' . $now->format('Y.m.d H:i:s'));
            $output->writeln('Last update: ' . $lastUpdateTime->format('Y.m.d H:i:s'));
            $output->writeln('Status: ' . ($isActive ? '<info>Active</info>' : '<fg=#a3c>Sleep</>') . ' - ' . $seconds);

            usleep($isActive ? 300 : 1000);
            // выводить кол-во страниц продуктов, общее, 90, 200, 210
        }

        return 0;
    }
}
