<?php

namespace ZnSandbox\Telegram\Actions;

use App\Core\Entities\RequestEntity;
use ZnSandbox\Telegram\Base\BaseAction;
use ZnSandbox\Telegram\Base\BaseAction2;
use ZnSandbox\Telegram\Entities\MessageEntity;

class EchoAction extends BaseAction2
{

    public function run(RequestEntity $requestEntity)
    {
        $this->response->sendMessage($requestEntity->getMessage()->getChat()->getId(), $requestEntity->getMessage()->getText());
    }

}