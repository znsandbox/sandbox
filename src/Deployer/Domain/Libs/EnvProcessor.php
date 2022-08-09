<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use Symfony\Component\Process\Process;
use ZnLib\Components\Time\Enums\TimeEnum;
use ZnSandbox\Sandbox\Deployer\Domain\Shell\LocalShell;
use function Deployer\run;

class EnvProcessor
{

    public static function locateBinaryPath($name)
    {
        $nameEscaped = escapeshellarg($name);

        // Try `command`, should cover all Bourne-like shells
        // Try `which`, should cover most other cases
        // Fallback to `type` command, if the rest fails

        $process = Process::fromShellCommandline("command -v $nameEscaped || which $nameEscaped || type -p $nameEscaped");
        $process->setTimeout(TimeEnum::SECOND_PER_YEAR);
        $process->run();
        if (!$process->isSuccessful()) {
//            dd($process->getOutput());
            throw new \Exception($process->getErrorOutput());
        }
        $path = $process->getOutput();


//        $localShell = new LocalShell();
//        $path = $localShell->runCommand("command -v $nameEscaped || which $nameEscaped || type -p $nameEscaped");
//        $path = run("command -v $nameEscaped || which $nameEscaped || type -p $nameEscaped");
        if ($path) {
            // Deal with issue when `type -p` outputs something like `type -ap` in some implementations
            return trim(str_replace("$name is", "", $path));
        }

        throw new \RuntimeException("Can't locate [$nameEscaped] - neither of [command|which|type] commands are available");
    }
}
