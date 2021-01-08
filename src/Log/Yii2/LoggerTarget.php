<?php

namespace ZnSandbox\Sandbox\Log\Yii2;

use Monolog\Logger as MonoLogger;
use Psr\Log\LoggerInterface;
use yii\helpers\VarDumper;
use yii\log\Logger as YiiLogger;
use yii\log\Target;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class LoggerTarget extends Target
{

    private $logger;

    public function __construct(LoggerInterface $logger, $config = [])
    {
        parent::__construct($config);
        $this->logger = $logger;
    }

    public function export()
    {
        foreach ($this->messages as $message) {
            $this->log($message);
//            throw new LogRuntimeException('Unable to export log through database!');
        }
    }

    private function log(array $message) {
        list($text, $level, $category, $timestamp, $trace, $memoryUsage) = $message;
        $context = [
            'level' => $level,
            'category' => $category,
        ];
        if (EnvHelper::isDebug()) {
            $context['trace'] = $trace;
            $context['memoryUsage'] = $memoryUsage;
        }
        $this->logger->log($this->encodeLevel($level), $this->encodeMessage($text), $context);
    }

    private function encodeMessage($text): string
    {
        if (!is_string($text)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            if ($text instanceof \Throwable || $text instanceof \Exception) {
                $text = (string)$text;
            } else {
                $text = VarDumper::export($text);
            }
        }
        return $text;
    }

    private function encodeLevel(int $level): int
    {
        $levelAssoc = [
            YiiLogger::LEVEL_TRACE => MonoLogger::DEBUG,
            YiiLogger::LEVEL_INFO => MonoLogger::INFO,
            YiiLogger::LEVEL_WARNING => MonoLogger::WARNING,
            YiiLogger::LEVEL_ERROR => MonoLogger::ERROR,
            YiiLogger::LEVEL_PROFILE => MonoLogger::DEBUG,
            YiiLogger::LEVEL_PROFILE_END => MonoLogger::DEBUG,
            YiiLogger::LEVEL_PROFILE_BEGIN => MonoLogger::DEBUG,
        ];
        return ArrayHelper::getValue($levelAssoc, $level, MonoLogger::CRITICAL);
    }
}
