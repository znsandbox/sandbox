<?php

namespace ZnSandbox\Telegram\Services;

use danog\MadelineProto\APIFactory;
use danog\MadelineProto\messages;
use ZnSandbox\Telegram\Entities\ResponseEntity;

class ResponseService
{

    /** @var UserService */
    private $user;

    /** @var APIFactory|messages */
    private $messages;

    public function __construct(APIFactory $messages, UserService $userService)
    {
        $this->messages = $messages;
        $this->user = $userService;
    }

    public function setApi(APIFactory $messages) {
        $this->messages = $messages;
    }

    public function getApi(): APIFactory {
        return $this->messages;
    }

    public function send(ResponseEntity $responseEntity) {
        if($responseEntity->getUserId()) {
            $responseEntity->setUserId($this->user->getCurrentUser()->getId());
        }
        $data = [];
        $data['peer'] = $responseEntity->getUserId();
        if($responseEntity->getMessage()) {
            $data['message'] = $responseEntity->getMessage();
        }
        if($responseEntity->getMedia()) {
            $data['media'] = $responseEntity->getMedia();
        }
        if($responseEntity->getReplyMessageId()) {
            $data['reply_to_msg_id'] = $responseEntity->getReplyMessageId();
        }
        return call_user_func([$this->messages, $responseEntity->getMethod()], $data);
        //return $this->messages->sendMessage($data);
    }

    public function sendMessage(string $text, int $userId = null, int $replyToMsgTd = null) {
        if(empty($userId)) {
            $userId = $this->user->getCurrentUser()->getId();
        }
        $data = [
            'peer' => $userId,
            'message' => $text,
        ];
        if($replyToMsgTd) {
            $data['reply_to_msg_id'] = $replyToMsgTd;
        }
        return $this->messages->sendMessage($data);
    }
}
