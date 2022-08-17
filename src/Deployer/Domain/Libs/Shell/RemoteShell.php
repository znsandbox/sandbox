<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\Shell;

use ZnLib\Console\Domain\Helpers\CommandLineHelper;
use ZnSandbox\Sandbox\Deployer\Domain\Entities\HostEntity;

class RemoteShell extends LocalShell
{

    private $hostEntity;

    public function getHostEntity(): HostEntity
    {
        return $this->hostEntity;
    }

    public function __construct(HostEntity $hostEntity)
    {
        $this->hostEntity = $hostEntity;
    }

    public function wrapCommand($command): string
    {
        $command = CommandLineHelper::argsToString($command, $this->lang);
        $command = escapeshellarg($command);

        /** @var HostEntity $hostEntity */
        $hostEntity = $this->getHostEntity();

//        $host = $hostEntity->getDsn();
        $port = $hostEntity->getPort();
        $host = "{$hostEntity->getUser()}@{$hostEntity->getHost()}";

        $cmd = "ssh -p $port $host $command";

//        dd($cmd);
        return $cmd;
    }

    public function runCommand($command, ?string $path = null): string
    {
        $ssh = $this->wrapCommand($command);
        $commandOutput = parent::runCommand($ssh);
        return $commandOutput;
    }
}