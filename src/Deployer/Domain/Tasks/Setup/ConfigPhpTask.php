<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\PhpShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class ConfigPhpTask extends BaseShell implements TaskInterface
{

    public function run()
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
