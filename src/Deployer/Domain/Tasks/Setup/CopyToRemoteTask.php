<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class CopyToRemoteTask extends BaseShell implements TaskInterface
{

    public $sourceFilePath = null;
    public $destFilePath = null;
    protected $title = 'Copy file to remote';

    public function run()
    {
        $fs = new FileSystemShell($this->remoteShell);
        $fs->uploadFile($this->sourceFilePath, $this->destFilePath);
    }
}
