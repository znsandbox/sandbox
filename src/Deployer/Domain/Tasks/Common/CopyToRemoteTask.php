<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Common;

use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;

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
