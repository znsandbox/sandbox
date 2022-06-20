<?php

namespace ZnSandbox\Sandbox\I18n\Domain\Interfaces\Services;

use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;
use ZnCore\Base\Libs\Query\Entities\Query;
use ZnSandbox\Sandbox\I18n\Domain\Entities\TranslateEntity;

interface TranslateServiceInterface
{

    public function oneByEntity(int $entityTypeId, int $entityId, int $languageId, Query $query = null): TranslateEntity;

    public function removeByUnique(int $entityTypeId, int $entityId): void;

    public function persist(int $entityTypeId, int $entityId, int $languageId, string $value): TranslateEntity;

    public function batchPersist(int $entityTypeId, int $entityId, array $values): Collection;
}
