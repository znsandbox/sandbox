<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Exceptions\ReadOnlyException;
use ZnCore\Contract\User\Exceptions\ForbiddenException;
use ZnCore\Domain\Enums\EventEnum;
use ZnCore\Domain\Events\EntityEvent;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

class MyChildBehavior implements EventSubscriberInterface
{

    use EntityManagerTrait;

    private $myPersonService;

    public function __construct(EntityManagerInterface $entityManager, MyPersonServiceInterface $myPersonService)
    {
        $this->setEntityManager($entityManager);
        $this->myPersonService = $myPersonService;
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEnum::BEFORE_UPDATE_ENTITY => 'onBefore',
            EventEnum::BEFORE_DELETE_ENTITY => 'onBefore',
        ];
    }

    public function onBefore(EntityEvent $event)
    {
        if (!$this->myPersonService->isMyChild($event->getEntity()->getId())) {
            throw new ForbiddenException('Not allowed');
        }
    }
}
