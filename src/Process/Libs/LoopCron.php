<?php

namespace ZnSandbox\Sandbox\Process\Libs;

use ZnCore\Base\Enums\Measure\TimeEnum;

class LoopCron
{

    private $sleepIntervalMicrosecond = 1 / TimeEnum::SECOND_PER_MICROSECOND;
    private $callback = null;
    private $isStarted = false;
    private $isPaused = false;
    private $name = null;
    private $locker = null;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->locker = new LockProcess($name, $this->sleepIntervalMicrosecond);
    }

    public function setSleepIntervalMicrosecond($sleepIntervalMicrosecond): void
    {
        $this->sleepIntervalMicrosecond = $sleepIntervalMicrosecond;
    }

    public function setCallback(callable $callback): void
    {
        $this->callback = $callback;
    }

    public function isStarted(): bool
    {
        return $this->isStarted || $this->locker->isLocked();
    }

    public function setIsStarted(bool $isStarted): void
    {
        if ($this->isStarted) {
            throw new \Exception('Already runned in this process!');
        }
        if ($this->locker->isLocked()) {
            throw new \Exception('Already runned in other process!');
        }
        $this->isStarted = $isStarted;
    }

    public function start(): void
    {
        if ($this->isPaused) {
            $this->isPaused = false;
            return;
        }
        $this->setIsStarted(true);
        $this->loop();
    }

    public function stop(): void
    {
        $this->setIsStarted(false);
        $this->locker->unlock();
    }

    public function pause(): void
    {
        $this->isPaused = true;
    }

    protected function loop(): void
    {
        while ($this->isStarted) {
            $this->call();
            usleep($this->sleepIntervalMicrosecond);
        }
    }

    protected function call(): void
    {
        $this->locker->touch();
        if ($this->isPaused) {
            return;
        }
        call_user_func($this->callback);
        $this->locker->touch();
    }
}
