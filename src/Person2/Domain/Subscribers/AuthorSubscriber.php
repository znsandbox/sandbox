<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Subscribers;

use App\News\Domain\Entities\CommentEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Contract\User\Exceptions\UnauthorizedException;
use ZnUser\Authentication\Domain\Interfaces\Services\AuthServiceInterface;
use ZnDomain\Domain\Enums\EventEnum;
use ZnDomain\Domain\Events\EntityEvent;
use ZnCore\Entity\Helpers\EntityHelper;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

class AuthorSubscriber implements EventSubscriberInterface
{

//    private $authService;
    private $myPersonService;
    private $attribute;

    public function __construct(
//        AuthServiceInterface $authService,
        MyPersonServiceInterface $myPersonService
    )
    {
//        $this->authService = $authService;
        $this->myPersonService = $myPersonService;
    }

    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEnum::BEFORE_CREATE_ENTITY => 'onCreateComment'
        ];
    }

    public function onCreateComment(EntityEvent $event)
    {
        $entity = $event->getEntity();
        $personId = $this->myPersonService->findOne()->getId();
        //$identityId = $this->authService->getIdentity()->getId();
        EntityHelper::setAttribute($entity, $this->attribute, $personId);
        try {

        } catch (UnauthorizedException $e) {
        }
    }
}
