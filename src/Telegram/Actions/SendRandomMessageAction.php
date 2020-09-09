<?php

namespace ZnSandbox\Telegram\Actions;

use danog\MadelineProto\APIFactory;
use ZnSandbox\Telegram\Base\BaseAction;
use ZnSandbox\Telegram\Entities\MessageEntity;

class SendRandomMessageAction extends BaseAction
{

    private $responseList;

    public function __construct(array $responseList)
    {
        parent::__construct();
        $this->responseList = $responseList;
    }

    public function run(MessageEntity $messageEntity)
    {
        $count = count($this->responseList);
        $randIndex = mt_rand(0, $count - 1);
        return $this->response->sendMessage($this->responseList[$randIndex], $messageEntity->getUserId());
    }

}