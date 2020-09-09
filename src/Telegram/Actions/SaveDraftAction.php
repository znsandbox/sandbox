<?php

namespace ZnSandbox\Telegram\Actions;

use danog\MadelineProto\APIFactory;
use ZnSandbox\Telegram\Base\BaseAction;
use ZnSandbox\Telegram\Entities\MessageEntity;
use ZnSandbox\Telegram\Entities\ResponseEntity;

class SaveDraftAction extends BaseAction
{

    private $text;

    public function __construct(string $text)
    {
        parent::__construct();
        $this->text = $text;
    }

    public function run(MessageEntity $messageEntity)
    {
        $responseEntity = new ResponseEntity;
        $responseEntity->setUserId($messageEntity->getUserId());
        $responseEntity->setMessage($this->text);
        $responseEntity->setMethod('saveDraft');
        return $this->response->send($responseEntity);
        /*return $this->messages->saveDraft([
            'peer' => $messageEntity->getUserId(),
            'message' => $this->text,
        ]);*/
    }

}