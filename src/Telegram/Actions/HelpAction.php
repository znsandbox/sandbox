<?php

namespace ZnSandbox\Telegram\Actions;

use danog\MadelineProto\APIFactory;
use ZnSandbox\Telegram\Base\BaseAction;
use ZnSandbox\Telegram\Entities\MessageEntity;
use ZnSandbox\Telegram\Handlers\BaseInputMessageEventHandler;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class HelpAction extends BaseAction
{

    /** @var BaseInputMessageEventHandler */
    public $eventHandler;

    public function __construct(/*BaseInputMessageEventHandler*/ $eventHandler)
    {
        parent::__construct();
        $this->eventHandler = $eventHandler;
    }

    public function run(MessageEntity $messageEntity)
    {
        $definitions = $this->eventHandler->definitions($this->response->getApi());
        $lines = [];
        foreach ($definitions as $definition) {
            if(!empty($definition['help'])) {
                $help = ArrayHelper::toArray($definition['help']);
                $lines[] = implode(PHP_EOL, $help);
            }
        }
        return $this->response->sendMessage(implode(PHP_EOL . PHP_EOL, $lines), $messageEntity->getUserId());
    }

}