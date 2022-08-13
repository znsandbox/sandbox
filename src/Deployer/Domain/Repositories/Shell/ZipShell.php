<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\BaseShellDriver;

class ZipShell extends BaseShellDriver
{

    private $directory;

    public function setDirectory(string $directory): void
    {
        $this->directory = $directory;
    }

    public function unZipAllToDir(string $zipFile, string $targetDirectory)
    {
        $this->shell->runCommand("cd \"{$targetDirectory}\" && unzip -o \"{$zipFile}\"");
    }
}
