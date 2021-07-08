<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Subscribers;

use ZnSandbox\Sandbox\UserSecurity\Domain\Enums\UserActionEventEnum;
use ZnBundle\User\Domain\Events\UserActionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\NotifyServiceInterface;
use ZnSandbox\Sandbox\UserSecurity\Domain\Enums\UserSecurityNotifyTypeEnum;

class SendNotifyAfterUpdatePasswordSubscriber implements EventSubscriberInterface
{

    use EntityManagerTrait;

    private $notifyService;

    public function __construct(
        NotifyServiceInterface $notifyService
    )
    {
        $this->notifyService = $notifyService;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserActionEventEnum::AFTER_UPDATE_PASSWORD => 'onAfterUpdatePassword',
        ];
    }

    public function onAfterUpdatePassword(UserActionEvent $event)
    {
        $this->notifyService->sendNotifyByTypeName(UserSecurityNotifyTypeEnum::UPDATE_PASSWORD, $event->getIdentityId());
    }
}
