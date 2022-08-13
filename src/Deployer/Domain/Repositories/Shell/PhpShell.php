<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\PhpConfig;

class PhpShell extends BaseShellDriver
{

    public function setConfig(string $configFile, array $config)
    {

        $fs = new FileSystemShell($this->shell);

        $content = $fs->downloadContent($configFile);
        $phpConfig = new PhpConfig($content);
        foreach ($config as $key => $value) {
            $phpConfig->enable($key);
            $phpConfig->set($key, $value);
        }
        $fs->uploadContent($content, $configFile);
    }
}
