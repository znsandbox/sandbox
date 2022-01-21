<?php

namespace ZnSandbox\Sandbox\Grabber\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;

class DomainCommand extends Command
{

    protected static $defaultName = 'grabber:queue';
    private $queueService;

    public function __construct(?string $name = null, QueueServiceInterface $queueService)
    {
        parent::__construct($name);
        $this->queueService = $queueService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=white># Grabber Queue</>');

        return 0;
    }

}
