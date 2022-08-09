<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use Deployer\ServerFs;
use ZnLib\Console\Domain\ShellNew\FileSystemShell;
use ZnLib\Console\Domain\ShellNew\Legacy\ApacheShell;
use ZnLib\Console\Domain\ShellNew\Legacy\PackageShell;
use ZnLib\Console\Domain\ShellNew\Legacy\PhpShell;
use function Deployer\get;

class ConfigureServerLampPhpShell extends BaseShell
{

    public function install()
    {
        $packageShell = new PackageShell($this->remoteShell);

        $packageShell->addRepository('ppa:ondrej/php');
        $packageShell->update();

        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);

        $basePackages = $config['php']['basePackages'];
        $basePackages = array_map([VarProcessor::class, 'process'], $basePackages);
        $packageShell->installBatch($basePackages);

        $packageShell->update();

        $extPackages = $config['php']['extPackages'];
        $extPackages = array_map([VarProcessor::class, 'process'], $extPackages);
        $packageShell->installBatch($extPackages);
    }

    public function config()
    {
        $fs = new FileSystemShell($this->remoteShell);
        $php = new PhpShell($this->remoteShell);


        $fs->sudo()->chmod('/etc/php', 'ugo+rwx', true);

        $php->setConfig('/etc/php/7.2/apache2/php.ini', [
            'short_open_tag' => 'On',
        ]);
        $php->setConfig('/etc/php/7.2/cli/php.ini', [
            'short_open_tag' => 'On',
            'memory_limit' => '512M',
            'max_input_time' => '600',
            'max_execution_time' => '120',
        ]);
    }
}
