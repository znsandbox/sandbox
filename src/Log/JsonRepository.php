<?php

namespace ZnSandbox\Sandbox\Log;

use Illuminate\Support\Collection;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\DomainInterface;
use ZnSandbox\Sandbox\Log\Domain\Entities\LogEntity;

class JsonRepository
{

    public function all()
    {
        $env = $_ENV['APP_ENV'];
        $logFileName = __DIR__ . '/../../../../../' . $_ENV['MONOLOG_DIR'] . '/' . $env . '.json';
        $lines = file($logFileName, \FILE_IGNORE_NEW_LINES);
        $collection = new Collection();
        foreach ($lines as &$line) {
            $line = json_decode($line);
            $logEntity = new LogEntity();
            EntityHelper::setAttributes($logEntity, $line);
            $collection->add($logEntity);
        }
        return $collection;
    }

}
