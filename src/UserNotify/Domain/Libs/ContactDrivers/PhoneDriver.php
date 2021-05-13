<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Libs\ContactDrivers;

use ZnBundle\Notify\Domain\Entities\SmsEntity;
use ZnBundle\Notify\Domain\Interfaces\Services\SmsServiceInterface;
use ZnBundle\User\Domain\Interfaces\Services\CredentialServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs\ContactDriverInterface;

class PhoneDriver implements ContactDriverInterface
{

    private $smsService;
    private $credentialService;

    public function __construct(
        SmsServiceInterface $smsService,
        CredentialServiceInterface $credentialService
    )
    {
        $this->smsService = $smsService;
        $this->credentialService = $credentialService;
    }

    public function send(NotifyEntity $notifyEntity)
    {
        $credentialEntity = $this->credentialService->oneByIdentityIdAndType($notifyEntity->getRecipientId(), 'phone');
        $smsEntity = new SmsEntity();
        $smsEntity->setPhone($credentialEntity->getCredential());
        $smsEntity->setMessage($notifyEntity->getSubject());
        $this->smsService->push($smsEntity);
    }
}