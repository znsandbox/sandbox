<?php

namespace ZnSandbox\Sandbox\Log\Yii2;

use Psr\Log\LoggerInterface;
use Yii;

class Logger implements LoggerInterface
{


    public function emergency($message, array $context = array())
    {
        $this->log(\Monolog\Logger::EMERGENCY, $message, $context);
    }

    public function alert($message, array $context = array())
    {
        $this->log(\Monolog\Logger::ALERT, $message, $context);
    }

    public function critical($message, array $context = array())
    {
        $this->log(\Monolog\Logger::CRITICAL, $message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->log(\Monolog\Logger::ERROR, $message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->log(\Monolog\Logger::WARNING, $message, $context);
    }

    public function notice($message, array $context = array())
    {
        $this->log(\Monolog\Logger::NOTICE, $message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->log(\Monolog\Logger::INFO, $message, $context);
    }

    public function debug($message, array $context = array())
    {
        $this->log(\Monolog\Logger::DEBUG, $message, $context);
    }

    public function log($level, $message, array $context = array())
    {
        dd(func_get_args());
        $assoc = [
            \Monolog\Logger::EMERGENCY => \yii\log\Logger::LEVEL_ERROR,
            \Monolog\Logger::ALERT => \yii\log\Logger::LEVEL_ERROR,
            \Monolog\Logger::CRITICAL => \yii\log\Logger::LEVEL_ERROR,
            \Monolog\Logger::ERROR => \yii\log\Logger::LEVEL_ERROR,
            \Monolog\Logger::WARNING => \yii\log\Logger::LEVEL_WARNING,
            \Monolog\Logger::NOTICE => \yii\log\Logger::LEVEL_INFO,
            \Monolog\Logger::INFO => \yii\log\Logger::LEVEL_INFO,
            \Monolog\Logger::DEBUG => \yii\log\Logger::LEVEL_PROFILE,
        ];
        Yii::$app->log->logger->log($message, $assoc[$level], 'logger');
    }
}
