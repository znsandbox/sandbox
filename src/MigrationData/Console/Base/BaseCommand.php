<?php

namespace ZnSandbox\Sandbox\MigrationData\Console\Base;

use ZnSandbox\Sandbox\MigrationData\Domain\Libs\SourceProvider;
use ZnSandbox\Sandbox\MigrationData\Domain\Libs\TargetProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZnCore\Domain\Libs\Query;

abstract class BaseCommand extends Command
{

    protected $sourceProvider;
    protected $targetProvider;
    protected $limit = 500;

    abstract protected function forgeSourceQuery(): Query;

    abstract public function persist(object $entity): void;

    public function __construct(
        $name = null,
        SourceProvider $sourceProvider,
        TargetProvider $targetProvider
    )
    {
        parent::__construct($name);
        $this->sourceProvider = $sourceProvider;
        $this->targetProvider = $targetProvider;

        $this->configureProviders();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $outputHandler = function (array $data) use ($output) {
            $message = "page {$data['page']} ... OK {$data['persistedCount']} / {$data['sourceCount']}";
            $output->writeln($message);
        };
        $this->targetProvider->persistAll($this->sourceProvider, $outputHandler);
        $this->total($output);
        return 0;
    }

    protected function total(OutputInterface $output)
    {
        $enrollCount = $this->sourceProvider->getCount();
        $processed = $this->targetProvider->getPersistedCount();
        if ($processed == $enrollCount) {
            $output->writeln('<fg=green>Success!!!</>');
        } else {
            $output->writeln('<fg=red>Fail!!! ' . $processed . ' / ' . $enrollCount . '</>');
        }
    }

    protected function configureProviders()
    {
        $this->sourceProvider->setQuery($this->forgeSourceQuery());
        $this->sourceProvider->setLimit($this->limit);

        $this->targetProvider->setPersistCallback([$this, 'persist']);
    }
}
