<?php

namespace ZnSandbox\Sandbox\Process\Libs;

use Symfony\Component\Lock\Exception\LockConflictedException;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\LockInterface;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnSandbox\Sandbox\Process\Exceptions\AlreadyStartedException;

class LoopCron
{

    private $sleepIntervalMicrosecond = 1 / TimeEnum::SECOND_PER_MICROSECOND;
    private $callback = null;
    private $isStarted = false;
    private $isPaused = false;
    private $name = null;
    //private $locker = null;
    private $lock = null;
    private $lockFactory;

    public function __construct(string $name, LockFactory $lockFactory)
    {
        $this->name = $name;
        $this->lockFactory = $lockFactory;
    }

    protected function getLocker(): LockInterface
    {
        if (!$this->lock) {
            $this->lock = $this->lockFactory->createLock($this->name);
        }
        return $this->lock;
    }

    public function setSleepIntervalMicrosecond($sleepIntervalMicrosecond): void
    {
        $this->sleepIntervalMicrosecond = $sleepIntervalMicrosecond;
    }

    public function setCallback(callable $callback): void
    {
        $this->callback = $callback;
    }

    /*protected function isStarted(): bool
    {
        return $this->isStarted || $this->locker->isLocked();
    }*/

    protected function setIsStarted(bool $isStarted): void
    {
        if ($isStarted) {
            if ($this->isStarted) {
                throw new AlreadyStartedException('Already started!');
            }
            if (!$this->getLocker()->acquire()) {
                throw new LockConflictedException('Locked in other process!');
            }
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
        $this->getLocker()->release();
    }

    public function pause(): void
    {
        $this->isPaused = true;
    }

    public function tick(): void
    {
        $this->getLocker()->refresh();
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
        $this->tick();
        if ($this->isPaused) {
            return;
        }
        call_user_func($this->callback);
        $this->tick();
    }
}
