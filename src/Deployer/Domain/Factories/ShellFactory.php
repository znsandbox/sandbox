<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Factories;

use ZnCore\Instance\Helpers\InstanceHelper;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Entities\HostEntity;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConnectionProcessor;
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

    public static function createRemoteShell(?string $connectionName = null): RemoteShell
    {
        $connection = ConnectionProcessor::get($connectionName);
//        $host = new HostEntity();
//        $host->setHost($connection['host'] ?? null);
//        $host->setPort($connection['port'] ?? 22);
//        $host->setUser($connection['user'] ?? null);
        $host = ConnectionProcessor::createEntity($connection);
        $remoteShell = new RemoteShell($host);
        return $remoteShell;
    }
}
