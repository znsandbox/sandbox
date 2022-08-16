<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Setup;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class MakeSoftLinkTask extends BaseShell implements TaskInterface
{

    public $sourceFilePath = null;
    public $linkFilePath = null;
    protected $title = 'Make link "{{linkFilePath}}" > "{{sourceFilePath}}"';

    public function run()
    {
        $fs = new FileSystemShell($this->remoteShell);
        $fs->sudo()->removeAny($this->linkFilePath);
        /*if ($fs->isDirectoryExists($this->linkFilePath)) {
            $fs->sudo()->removeDir($this->linkFilePath);
        } elseif ($fs->isFileExists($this->linkFilePath)) {
            $fs->sudo()->removeFile($this->linkFilePath);
        }*/
        $fs->sudo()->makeLink($this->sourceFilePath, $this->linkFilePath, '-s');
    }
}
