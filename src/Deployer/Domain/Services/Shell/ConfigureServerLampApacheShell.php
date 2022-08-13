<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Services\Shell;

use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PackageShell;

class ConfigureServerLampApacheShell extends BaseShell
{

    public function install()
    {
        $this->io->writeln('install apache2 ... ');

        $packageShell = new PackageShell($this->remoteShell);
        $packageShell->install('apache2');

        $this->io->writeln('start apache2 ... ');
        $apacheShell = new ApacheShell($this->remoteShell);
        $apacheShell->start();

//        dd($apacheShell->status());
    }

    public function config()
    {
        $apacheShell = new ApacheShell($this->remoteShell);

        $this->io->writeln('apache2 enableRewrite ... ');
        $apacheShell->enableRewrite();

        $this->io->writeln('set permissions ... ');
        $this->setPermission();

        $this->io->writeln('link sites enabled ... ');
        $this->linkSitesEnabled();

        $this->io->writeln('update apache2 config ... ');
        $this->updateConfig();

        $this->io->writeln('enable apache2 autorun ... ');
        $apacheShell->enableAutorun();

        $this->io->writeln('apache2 restart ... ');
        $apacheShell->restart();
    }

    private function setPermission()
    {
        $fs = new FileSystemShell($this->remoteShell);
        $user = $this->remoteShell->getHostEntity()->getUser();
        $fs->sudo()->chmod('/etc/apache2', 'ugo+rwx', true);
        $fs->sudo()->chown('/var/www', "$user:www-data");
        $fs->sudo()->chmod('/var/www', 'g+s');
    }

    private function linkSitesEnabled()
    {
        $fs = new FileSystemShell($this->remoteShell);
        if (!$fs->isFileExists('/etc/apache2/sites-enabled.bak')) {
            $fs->move('/etc/apache2/sites-enabled', '/etc/apache2/sites-enabled.bak');
            $fs->makeLink('/etc/apache2/sites-available', '/etc/apache2/sites-enabled', '-s');
        }
    }

    private function updateConfig()
    {
        $fs = new FileSystemShell($this->remoteShell);
        $sourceConfigFile = realpath(__DIR__ . '/../../../resources/apache2.conf');
        if (!$fs->isFileExists('/etc/apache2/apache2.conf.bak')) {
            $fs->move('/etc/apache2/apache2.conf', '/etc/apache2/apache2.conf.bak');
            $fs->uploadIfNotExist($sourceConfigFile, '/etc/apache2/apache2.conf');
        }
    }
}
