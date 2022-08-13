<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\PhpConfig2;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\BaseShellDriver;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\FileSystemShell;

class PhpShell extends BaseShellDriver
{

    public function setConfig(string $configFile, array $config) {

        $fs = new FileSystemShell($this->shell);

        $content = $fs->downloadContent($configFile);
        $phpConfig = new PhpConfig2($content);
        foreach ($config as $key => $value) {
            $phpConfig->enable($key);
            $phpConfig->set($key, $value);
        }
        $fs->uploadContent($content, $configFile);
    }
}
