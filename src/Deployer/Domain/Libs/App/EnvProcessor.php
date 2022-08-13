<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs\App;

use Symfony\Component\Process\Process;
use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnLib\Console\Domain\Helpers\CommandLineHelper;

class EnvProcessor
{

    use SingletonTrait;

    public static function locateBinaryPath($name)
    {
        $nameEscaped = escapeshellarg($name);

        // Try `command`, should cover all Bourne-like shells
        // Try `which`, should cover most other cases
        // Fallback to `type` command, if the rest fails

        $process = Process::fromShellCommandline("command -v $nameEscaped || which $nameEscaped || type -p $nameEscaped");
//        $process->setTimeout(TimeEnum::SECOND_PER_YEAR);
        CommandLineHelper::run($process);
        $path = $process->getOutput();

        if ($path) {
            // Deal with issue when `type -p` outputs something like `type -ap` in some implementations
            return trim(str_replace("$name is", "", $path));
        }

        throw new \RuntimeException("Can't locate [$nameEscaped] - neither of [command|which|type] commands are available");
    }
}
