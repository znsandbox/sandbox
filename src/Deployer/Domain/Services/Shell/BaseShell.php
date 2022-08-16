<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Services\Shell;

use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\Shell\LocalShell;

abstract class BaseShell
{

    protected $localShell;
    protected $remoteShell;
    protected $io;
    protected $title;

    public function getTitle(): ?string
    {
        if ($this->title == null) {
            return static::class;
        }
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function __construct(BaseShellNew $remoteShell, IO $io)
    {
        $this->localShell = new LocalShell();
        $this->remoteShell = $remoteShell;
        $this->io = $io;
    }
}
