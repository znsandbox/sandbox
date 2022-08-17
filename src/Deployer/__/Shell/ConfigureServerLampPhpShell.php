<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Services\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PackageShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PhpShell;

class ConfigureServerLampPhpShell extends BaseShell
{

    public function install()
    {
        $packageShell = new PackageShell($this->remoteShell);

        $this->io->writeln('add package repository ... ');
        $packageShell->addRepository('ppa:ondrej/php');

        $this->io->writeln('package update ... ');
        $packageShell->update();

//        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);

        $this->io->writeln('install base PHP packages ... ');
//        $basePackages = $config['php']['basePackages'];
        $basePackages = ConfigProcessor::get('php.basePackages');
        $basePackages = VarProcessor::processList($basePackages);


//        $basePackages = array_map([VarProcessor::class, 'process'], $basePackages);
        $packageShell->installBatch($basePackages);

        $this->io->writeln('package update ... ');
        $packageShell->update();

        $this->io->writeln('install ext PHP packages ... ');

//        $extPackages = $config['php']['extPackages'];
        $extPackages = ConfigProcessor::get('php.extPackages');
        $extPackages = VarProcessor::processList($extPackages);
//        $extPackages = array_map([VarProcessor::class, 'process'], $extPackages);
        $packageShell->installBatch($extPackages);
    }

    public function config()
    {
        $fs = new FileSystemShell($this->remoteShell);
        $php = new PhpShell($this->remoteShell);

        $this->io->writeln('PHP config ... ');

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