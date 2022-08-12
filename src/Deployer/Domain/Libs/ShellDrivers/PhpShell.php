<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\BaseShellNew2;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\ShellDrivers\FileSystemShell;
use ZnTool\Deployer\Libs\PhpConfig2;

class PhpShell extends BaseShellNew2
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
