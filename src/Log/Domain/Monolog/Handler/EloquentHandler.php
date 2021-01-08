<?php declare(strict_types=1);

namespace ZnSandbox\Sandbox\Log\Domain\Monolog\Handler;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use ZnSandbox\Sandbox\Log\Domain\Interfaces\Repositories\LogRepositoryInterface;
use ZnSandbox\Sandbox\Log\Domain\Monolog\Formatter\EloquentFormatter;

class EloquentHandler extends AbstractProcessingHandler
{

    private $logRepository;

    public function __construct($level = Logger::DEBUG, bool $bubble = true, LogRepositoryInterface $logRepository)
    {
        parent::__construct($level, $bubble);
        $this->logRepository = $logRepository;
    }

    protected function write(array $record): void
    {
        $this->logRepository->create($record['formatted']);
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new EloquentFormatter();
    }
}
