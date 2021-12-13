<?php

namespace ZnSandbox\Sandbox\I18n\Domain\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;
use ZnCore\Domain\Enums\EventEnum;
use ZnCore\Domain\Events\EntityEvent;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;
use ZnSandbox\Sandbox\I18n\Domain\Interfaces\Services\TranslateServiceInterface;

class MyChildBehavior implements EventSubscriberInterface
{

    use EntityManagerTrait;

    public $attribute = null;

    private $translateService;

    public function __construct(
        EntityManagerInterface $entityManager,
        TranslateServiceInterface $translateService
    )
    {
        $this->setEntityManager($entityManager);
        $this->translateService = $translateService;
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEnum::BEFORE_CREATE_ENTITY => 'onBeforeUpdateOrCreate',
            EventEnum::BEFORE_UPDATE_ENTITY => 'onBeforeUpdateOrCreate',
            EventEnum::BEFORE_DELETE_ENTITY => 'onBeforeDelete',
        ];
    }

    public function onBeforeUpdateOrCreate(EntityEvent $event)
    {
        $entity = $event->getEntity();
        $i18nArray = EntityHelper::getValue($entity, $this->attribute);
        $this->translateService->batchPersist(1, $entity->getId(), $i18nArray);
    }

    public function onBeforeDelete(EntityEvent $event)
    {
        /** @var EntityIdInterface $entity */
        $entity = $event->getEntity();
        $this->translateService->removeByUnique(1, $entity->getId());
    }

    private function getTypeId(object $entity): int
    {
        $className = get_class($entity);
        $assoc = [

        ];
    }
}
