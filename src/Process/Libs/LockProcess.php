<?php

namespace ZnSandbox\Sandbox\Process\Libs;

use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Base\Libs\FileSystem\Helpers\FileStorageHelper;
use ZnCore\Base\Libs\Store\Helpers\StoreHelper;

class LockProcess
{

    private $sleepIntervalMicrosecond;
    private $callback = null;
    private $isStarted = false;
    private $isPaused = false;
    private $name = null;

    public function __construct(string $name, float $sleepIntervalMicrosecond)
    {
        $this->name = $name;
        $this->sleepIntervalMicrosecond = $sleepIntervalMicrosecond;
    }

    public function touch(): void
    {
        $filename = $this->lockFileName();
        $microtime = microtime(true);
        StoreHelper::save($filename, [
            'name' => $this->name,
            'lastModify' => $microtime,
        ], 'json');
//        FileStorageHelper::save($filename, $microtime);
    }

    public function unlock(): void
    {
        $filename = $this->lockFileName();
        FileStorageHelper::remove($filename);
    }

    public function isLocked(): bool
    {
        $lastModify = $this->lastModify();
        if ($lastModify == null) {
            return false;
        }
        $elasped = microtime(true) - $lastModify;
        $interval = $this->sleepIntervalMicrosecond * TimeEnum::SECOND_PER_MICROSECOND;
        $isRun = $interval * 2 > $elasped;
        return $isRun;
    }

    protected function lockFileName(): string
    {
        return DotEnv::get('LOOP_CRON_DIRECTORY') . '/' . $this->name . '.lock';
    }

    protected function lastModify(): ?float
    {
        $filename = $this->lockFileName();
        if (!file_exists($filename)) {
            return null;
        }
        $data = StoreHelper::load($filename, null, null, 'json');
        return $data['lastModify'] ?? null;

//        return FileStorageHelper::load($filename);
    }

    protected function lock(): void
    {

    }
}
