<?php

namespace ZnSandbox\Sandbox\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;
use ZnSandbox\Sandbox\App\Enums\AppEventEnum;

class WebDetectTestEnvSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            AppEventEnum::BEFORE_INIT_ENV => 'onBeforeInitEnv',
        ];
    }

    public function onBeforeInitEnv(Event $event)
    {
        global $_GET, $_SERVER;
        $isWebTest = (isset($_SERVER['HTTP_ENV_NAME']) && $_SERVER['HTTP_ENV_NAME'] == 'test') || (isset($_GET['env']) && $_GET['env'] == 'test');
        if ($isWebTest) {
            $_ENV['APP_ENV'] = 'test';
        }
    }
}
