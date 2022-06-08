<?php

namespace ZnSandbox\Sandbox\Process\Libs;

use Symfony\Component\Lock\Exception\LockConflictedException;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\LockInterface;
use Symfony\Component\Lock\Store\SemaphoreStore;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnSandbox\Sandbox\Process\Exceptions\AlreadyStartedException;
//use ZnSandbox\Sandbox\Process\Exceptions\LockedException;

class LoopCron
{

    private $sleepIntervalMicrosecond = 1 / TimeEnum::SECOND_PER_MICROSECOND;
    private $callback = null;
    private $isStarted = false;
    private $isPaused = false;
    private $name = null;
    //private $locker = null;
    private $lock = null;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->lock = $this->createLockInstance($name);
        //$this->locker = new LockProcess($name, $this->sleepIntervalMicrosecond);
    }

    protected function createLockInstance(string $name): LockInterface
    {
        $store = new SemaphoreStore();
        $factory = new LockFactory($store);
        return $factory->createLock($name, 30);
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
            if (!$this->lock->acquire()) {
                throw new LockConflictedException('Locked in other process!');
            }
            /*if ($this->locker->isLocked()) {
                throw new LockedException('Locked in other process!');
            }*/
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
//        $this->locker->lock();
        $this->loop();
    }

    public function stop(): void
    {
        $this->setIsStarted(false);
//        $this->locker->unlock();
        $this->lock->release();
    }

    public function pause(): void
    {
        $this->isPaused = true;
    }

    public function tick(): void
    {
//        $this->locker->touch();
        $this->lock->refresh();
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
