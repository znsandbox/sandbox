<?php

namespace ZnSandbox\Sandbox\I18n\Domain\Services;

use Illuminate\Support\Collection;
use ZnCore\Domain\Base\BaseService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\I18n\Domain\Entities\TranslateEntity;
use ZnSandbox\Sandbox\I18n\Domain\Interfaces\Repositories\TranslateRepositoryInterface;
use ZnSandbox\Sandbox\I18n\Domain\Interfaces\Services\TranslateServiceInterface;

/**
 * @method TranslateRepositoryInterface getRepository()
 */
class TranslateService extends BaseService implements TranslateServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return TranslateEntity::class;
    }

    public function oneByEntity(int $entityTypeId, int $entityId, int $languageId, Query $query = null): TranslateEntity
    {
        return $this->getRepository()->oneByEntity($entityTypeId, $entityId, $languageId, $query);
    }

    public function removeByUnique(int $entityTypeId, int $entityId): void
    {
        $this->getRepository()->deleteByCondition([
            'entity_type_id' => $entityTypeId,
            'entity_id' => $entityId,
        ]);
    }

    public function persist(int $entityTypeId, int $entityId, int $languageId, string $value): TranslateEntity
    {
        $translateEntity = new TranslateEntity();
        $translateEntity->setEntityTypeId($entityTypeId);
        $translateEntity->setEntityId($entityId);
        $translateEntity->setLanguageId($languageId);
        $translateEntity->setValue($value);
        $this->getEntityManager()->persist($translateEntity);
        return $translateEntity;
    }

    public function batchPersist(int $entityTypeId, int $entityId, array $values): Collection
    {
        $collection = new Collection();
        foreach ($values as $languageId => $value) {
            $translateEntity = $this->persist($entityTypeId, $entityId, $languageId, $value);
            $collection->add($translateEntity);
        }
        return $collection;
    }
}
