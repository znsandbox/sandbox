<?php

namespace ZnSandbox\Sandbox\I18n\Domain\Subscribers;

use App\Workshop\Domain\Entities\CategoryEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;
use ZnCore\Domain\Enums\EventEnum;
use ZnCore\Domain\Events\EntityEvent;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;
use ZnSandbox\Sandbox\I18n\Domain\Interfaces\Services\TranslateServiceInterface;

class SyncTranslateBehavior implements EventSubscriberInterface
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
        $entityTypeId = $this->getTypeId($entity);
        $this->translateService->batchPersist($entityTypeId, $entity->getId(), $i18nArray);
    }

    public function onBeforeDelete(EntityEvent $event)
    {
        /** @var EntityIdInterface $entity */
        $entity = $event->getEntity();
        $entityTypeId = $this->getTypeId($entity);
        $this->translateService->removeByUnique($entityTypeId, $entity->getId());
    }

    private function getTypeId(object $entity): int
    {
        $className = get_class($entity);
        $assoc = [
            CategoryEntity::class => 10,
        ];
        return $assoc[$className];
    }
}
