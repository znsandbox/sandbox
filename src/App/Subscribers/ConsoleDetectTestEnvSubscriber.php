<?php

namespace ZnSandbox\Sandbox\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;
use ZnSandbox\Sandbox\App\Enums\AppEventEnum;

class ConsoleDetectTestEnvSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            AppEventEnum::BEFORE_INIT_ENV => 'onBeforeInitEnv',
        ];
    }

    public function onBeforeInitEnv(Event $event)
    {
        global $argv;
        $isConsoleTest = isset($argv) && in_array('--env=test', $argv);
        if ($isConsoleTest) {
            $_ENV['APP_ENV'] = 'test';
        }
    }
}
