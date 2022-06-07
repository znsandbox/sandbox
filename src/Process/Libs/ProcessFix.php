<?php

namespace ZnSandbox\Sandbox\Process\Libs;

class ProcessFix
{

    protected $backup = [];

    /*public function start(callable $callback = null, array $env = [])
    {
        $this->backupEnv();
//        parent::start($callback, $env);
        $this->restoreEnv();
    }*/

    public function backupEnv(): void
    {
        $this->backup = [];
        foreach ($_ENV as $key => $value) {
            if (is_array($value)) {
                $this->backup[$key] = $value;
                $_ENV[$key] = '';
            }
        }
    }

    public function restoreEnv(): void
    {
        foreach ($this->backup as $key => $value) {
            $_ENV[$key] = $value;
        }
        $this->backup = [];
    }
}
