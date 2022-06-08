<?php

namespace ZnSandbox\Sandbox\Process\Libs;

use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Base\Libs\FileSystem\Helpers\FileStorageHelper;
use ZnCore\Base\Libs\Store\Helpers\StoreHelper;
use ZnSandbox\Sandbox\Process\Exceptions\FileOpenException;
use ZnSandbox\Sandbox\Process\Exceptions\FileWriteException;
use ZnSandbox\Sandbox\Process\Exceptions\LockedException;

DeprecateHelper::hardThrow();

class LockProcess
{

    private $sleepIntervalMicrosecond;
    private $callback = null;
    private $isStarted = false;
    private $isPaused = false;
    private $name = null;
    private $lockFileResource = null;
    private $isRegisteredUnlockOnShutdown = false;

    public function __construct(string $name, float $sleepIntervalMicrosecond)
    {
        $this->name = $name;
        $this->sleepIntervalMicrosecond = $sleepIntervalMicrosecond;
    }

    public function touch(): void
    {
        $microtime = microtime(true);
        $data = [
            'name' => $this->name,
            'lastModify' => $microtime,
        ];
        ftruncate($this->lockFileResource, 0); // очищаем файл

        $result = fwrite($this->lockFileResource, json_encode($data, JSON_PRETTY_PRINT)); // запись
        if(!$result) {
            throw new FileWriteException("Ошибка записи!");
        }
//        $filename = $this->lockFileName();
//        StoreHelper::save($filename, $data, 'json');
//        FileStorageHelper::save($filename, $microtime);
    }

    public function lock(): void
    {
        $filename = $this->lockFileName();

        if(FileStorageHelper::isLocked($filename)) {
            throw new LockedException('Locked!');
        }

        if(!FileStorageHelper::has($filename)) {
            FileStorageHelper::touchFile($filename, '');
        }

        $this->lockFileResource = fopen($filename, 'r+'); // or die("Ошибка открытия файла");
        if(!$this->lockFileResource) {
            throw new FileOpenException('Ошибка открытия файла');
        }

        $isLocked = flock($this->lockFileResource, LOCK_EX); // установка исключительной блокировки на запись
        if(!$isLocked) {
            throw new LockedException('Locked!');
        }

//        $this->registerUnlockOnShutdown();
    }

    public function unlock(): void
    {
        if(!$this->lockFileResource) {
            return;
        }

//        $filename = $this->lockFileName();

        flock($this->lockFileResource, LOCK_UN); // снятие блокировки
        fclose($this->lockFileResource);
        $filename111 = $this->lockFileName();
        FileStorageHelper::remove($filename111);
        $this->lockFileResource = null;

//        FileStorageHelper::remove($filename);
    }

    public function isLocked(): bool
    {
        if($this->lockFileResource) {
            return true;
        }
        $filename = $this->lockFileName();
        return FileStorageHelper::isLocked($filename);


        /*$lastModify = $this->lastModify();
        if ($lastModify == null) {
            return false;
        }
        $elasped = microtime(true) - $lastModify;
        $interval = $this->sleepIntervalMicrosecond * TimeEnum::SECOND_PER_MICROSECOND;
        $isRun = $interval * 2 > $elasped;
        return $isRun;*/
    }

    protected function registerUnlockOnShutdown(): void {
        if($this->isRegisteredUnlockOnShutdown) {
            return;
        }
        register_shutdown_function([$this, 'unlock']);
        $this->isRegisteredUnlockOnShutdown = true;
    }

    protected function lockFileName(): string
    {
        return DotEnv::get('LOOP_CRON_DIRECTORY') . '/' . $this->name . '.lock';
    }

    /*protected function lastModify(): ?float
    {
        $filename = $this->lockFileName();
        if (!file_exists($filename)) {
            return null;
        }
        $data = StoreHelper::load($filename, null, null, 'json');
        return $data['lastModify'] ?? null;

//        return FileStorageHelper::load($filename);
    }*/
}
