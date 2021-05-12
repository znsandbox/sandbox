<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Libs\ContactDrivers;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs\ContactDriverInterface;
use ZnBundle\Person\Domain\Services\ContactService;
use ZnBundle\Notify\Domain\Entities\SmsEntity;
use ZnBundle\Notify\Domain\Interfaces\Repositories\SmsRepositoryInterface;

class PhoneDriver implements ContactDriverInterface
{

    const SMS_TYPE_ID = 1;
    const EMAIL_TYPE_ID = 2;

    private $smsRepository;
    private $contactService;

    public function __construct(
        SmsRepositoryInterface $smsRepository,
        ContactService $contactService
    )
    {
        $this->smsRepository = $smsRepository;
        $this->contactService = $contactService;
    }

    public function send(NotifyEntity $notifyEntity)
    {
        $phone = $this->contactService->oneMainContactByUserId($notifyEntity->getRecipientId(), self::SMS_TYPE_ID)->getValue();
        $smsEntity = new SmsEntity();
        $smsEntity->setPhone($phone);
        $smsEntity->setMessage($notifyEntity->getSubject());
        $this->smsRepository->send($smsEntity);
    }
}