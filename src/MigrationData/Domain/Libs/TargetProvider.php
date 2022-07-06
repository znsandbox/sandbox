<?php

namespace ZnSandbox\Sandbox\MigrationData\Domain\Libs;

use App\Card\Domain\Events\PersistEvent;
use ZnCore\EventDispatcher\Traits\EventDispatcherTrait;
use ZnCore\Domain\Enums\EventEnum;
use ZnCore\Domain\Events\EntityEvent;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\EntityManager\Traits\EntityManagerAwareTrait;

class TargetProvider
{

    use EntityManagerAwareTrait;
    use EventDispatcherTrait;

    private $persistCallback;
    private $persisted = 0;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->setEntityManager($em);
    }

    public function setPersistCallback($persistCallback): void
    {
        $this->persistCallback = $persistCallback;
    }

    public function getPersistedCount(): int
    {
        return $this->persisted;
    }

    public function persistAll(SourceProvider $sourceProvider, $outputHandler): void
    {
        $enrollCount = $sourceProvider->getCount();
        do {
            $data = [
                'page' => $sourceProvider->getPage(),
                'sourceCount' => $enrollCount,
            ];

            $collection = $sourceProvider->getNextCollection();
            foreach ($collection as $entity) {
                $this->persist($entity);
            }
            $data['persistedCount'] = $this->getPersistedCount();

            $event = new PersistEvent($data);
            $this->getEventDispatcher()->dispatch($event, 'collection.after_create');

            call_user_func($outputHandler, $data);
        } while ($collection->count());
    }

    public function persist(object $entity): void
    {
        $event = new EntityEvent($entity);

        $this->getEventDispatcher()->dispatch($event, EventEnum::BEFORE_CREATE_ENTITY);
        call_user_func($this->persistCallback, $entity);
        $this->persisted++;

        $this->getEventDispatcher()->dispatch($event, EventEnum::AFTER_CREATE_ENTITY);
    }
}
