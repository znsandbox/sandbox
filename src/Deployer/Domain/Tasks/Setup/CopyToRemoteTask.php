<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;

class CopyToRemoteTask extends BaseShell implements TaskInterface
{

    public $sourceFilePath = null;
    public $destFilePath = null;
    protected $title = 'Copy file to remote';

    public function run()
    {
        $fs = new FileSystemShell($this->remoteShell);
        $tmpDir = VarProcessor::process('{{homeUserDir}}/tmp');
        $fs->makeDirectory($tmpDir);
        $fs->uploadFile($this->sourceFilePath, $tmpDir . '/' . basename($this->destFilePath));
        $fs->move($tmpDir . '/' . basename($this->destFilePath), $this->destFilePath);
    }
}
