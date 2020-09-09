<?php

namespace ZnSandbox\Telegram\Actions;

use danog\MadelineProto\APIFactory;
use danog\MadelineProto\EventHandler;
use ZnSandbox\Telegram\Base\BaseAction;
use ZnSandbox\Telegram\Entities\MessageEntity;

class ShutdownServerAction extends BaseAction
{

    private $eventHandler;

    public function __construct(EventHandler $eventHandler)
    {
        parent::__construct();
        $this->eventHandler = $eventHandler;
    }

    public function run(MessageEntity $messageEntity)
    {
        // powercfg /hibernate off
        //shell_exec('rundll32.exe powrprof.dll,SetSuspendState 0,1,0');
        shell_exec('Rundll32.exe powrprof.dll,SetSuspendState 0');
    }

}