<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Subscribers;

use App\News\Domain\Entities\CommentEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Contract\User\Exceptions\UnauthorizedException;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnCore\Domain\Domain\Enums\EventEnum;
use ZnCore\Domain\Domain\Events\EntityEvent;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
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
        $personId = $this->myPersonService->one()->getId();
        //$identityId = $this->authService->getIdentity()->getId();
        EntityHelper::setAttribute($entity, $this->attribute, $personId);
        try {

        } catch (UnauthorizedException $e) {
        }
    }
}
