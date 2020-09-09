<?php

namespace ZnSandbox\Telegram\Actions;

use danog\MadelineProto\APIFactory;
use danog\MadelineProto\EventHandler;
use ZnSandbox\Telegram\Base\BaseAction;
use ZnSandbox\Telegram\Entities\MessageEntity;

class ShutdownHandlerAction extends BaseAction
{

    private $eventHandler;

    public function __construct(EventHandler $eventHandler)
    {
        parent::__construct($messages);
        $this->eventHandler = $eventHandler;
    }

    public function run(MessageEntity $messageEntity)
    {
        $this->eventHandler->stop();
    }

}