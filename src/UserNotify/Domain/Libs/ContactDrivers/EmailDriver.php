<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Libs\ContactDrivers;

use ZnBundle\Notify\Domain\Interfaces\Services\EmailServiceInterface;
use ZnBundle\User\Domain\Interfaces\Services\CredentialServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs\ContactDriverInterface;
use ZnBundle\Person\Domain\Services\ContactService;
use Yii;
use ZnBundle\Notify\Domain\Entities\EmailEntity;
use ZnBundle\Notify\Domain\Interfaces\Repositories\EmailRepositoryInterface;

class EmailDriver implements ContactDriverInterface
{

    private $emailService;
    private $credentialService;

    public function __construct(
        EmailServiceInterface $emailService,
        CredentialServiceInterface $credentialService
    )
    {
        $this->emailService = $emailService;
        $this->credentialService = $credentialService;
    }

    public function send(NotifyEntity $notifyEntity)
    {
        $credentialEntity = $this->credentialService->oneByIdentityIdAndType($notifyEntity->getRecipientId(), 'email');
        $emailEntity = new EmailEntity();
        $emailEntity->setTo($credentialEntity->getCredential());
        $emailEntity->setSubject($notifyEntity->getSubject());
        $emailEntity->setBody($notifyEntity->getContent());
        $this->emailService->push($emailEntity);
    }
}