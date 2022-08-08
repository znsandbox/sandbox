<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Factories;

use ZnSandbox\Sandbox\Deployer\Domain\Entities\HostEntity;
use ZnSandbox\Sandbox\Deployer\Domain\Shell\RemoteShell;

class ShellFactory
{

    public static function create(/*string $host, int $port, string $user*/): RemoteShell
    {
        $host = new HostEntity();
        $host->setHost('localhost');
        $host->setPort(2222);
        $host->setUser('user');
        $remoteShell = new RemoteShell($host);
        return $remoteShell;
    }
}
