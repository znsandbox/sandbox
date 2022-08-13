<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Factories;

use ZnSandbox\Sandbox\Deployer\Domain\Entities\HostEntity;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Shell\RemoteShell;

class ShellFactory
{

    public static function createRemoteShell(string $connectionName = 'default'): RemoteShell
    {
        $host = new HostEntity();

        $connection = ConfigProcessor::get("connections.$connectionName");

//        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
//        $connection = $config['connections'][$connectionName];

        $host->setHost($connection['host'] ?? null);
        $host->setPort($connection['port'] ?? 22);
        $host->setUser($connection['user'] ?? null);
        $remoteShell = new RemoteShell($host);
        return $remoteShell;
    }
}
