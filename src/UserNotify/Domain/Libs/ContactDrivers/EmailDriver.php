<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Libs\ContactDrivers;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs\ContactDriverInterface;
use ZnBundle\Person\Domain\Services\ContactService;
use Yii;
use ZnBundle\Notify\Domain\Entities\EmailEntity;
use ZnBundle\Notify\Domain\Interfaces\Repositories\EmailRepositoryInterface;

class EmailDriver implements ContactDriverInterface
{

    const SMS_TYPE_ID = 1;
    const EMAIL_TYPE_ID = 2;

    private $emailRepository;
    private $contactService;

    public function __construct(
        EmailRepositoryInterface $emailRepository,
        ContactService $contactService
    )
    {
        $this->emailRepository = $emailRepository;
        $this->contactService = $contactService;
    }

    public function send(NotifyEntity $notifyEntity)
    {
        $email = $this->contactService->oneMainContactByUserId($notifyEntity->getRecipientId(), self::EMAIL_TYPE_ID)->getValue();
        $emailEntity = new EmailEntity();
        $emailEntity->setFrom(Yii::$app->params['senderEmail']);
        $emailEntity->setTo($email);
        $emailEntity->setSubject($notifyEntity->getSubject());
        $emailEntity->setBody($notifyEntity->getContent());
        $this->emailRepository->send($emailEntity);
    }
}