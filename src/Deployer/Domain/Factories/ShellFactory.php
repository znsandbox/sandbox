<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Factories;

use ZnCore\Instance\Helpers\InstanceHelper;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Entities\HostEntity;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\Shell\RemoteShell;

class ShellFactory
{

    public static function createTask($definition, IO $io): TaskInterface
    {
        $remoteShell = ShellFactory::createRemoteShell();
        return InstanceHelper::create($definition, [
            BaseShellNew::class => $remoteShell,
            IO::class => $io,
        ]);
    }

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
