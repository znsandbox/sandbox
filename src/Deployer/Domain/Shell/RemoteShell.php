<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Shell;

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
        $host = $this->hostEntity->getDsn();
        return "ssh $host $command";
    }

    public function runCommand($command, ?string $path = null): string
    {
        $ssh = $this->wrapCommand($command);
        $commandOutput = parent::runCommand($ssh);
        return $commandOutput;
    }
}
