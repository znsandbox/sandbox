<?php declare(strict_types=1);

namespace ZnSandbox\Sandbox\Log\Domain\Monolog\Handler;

use Illuminate\Support\Collection;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use ZnSandbox\Sandbox\Log\Domain\Interfaces\Repositories\LogRepositoryInterface;
use ZnSandbox\Sandbox\Log\Domain\Monolog\Formatter\EloquentFormatter;

class EloquentHandler extends AbstractProcessingHandler
{

    private $logRepository;
    private $messages;

    public function __construct($level = Logger::DEBUG, bool $bubble = true, LogRepositoryInterface $logRepository)
    {
        parent::__construct($level, $bubble);
        $this->logRepository = $logRepository;
        $this->messages = new Collection();
        register_shutdown_function(function () {
            register_shutdown_function([$this, 'commit'], true);
        });
    }

    protected function write(array $record): void
    {
        $this->messages->add($record['formatted']);
    }

    public function commit()
    {
        $this->logRepository->createCollection($this->messages);
    }

    protected function getDefaultFormatter(): FormatterInterface
    {
        return new EloquentFormatter();
    }
}
