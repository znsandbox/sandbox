<?php

namespace ZnSandbox\Sandbox\I18n\Domain\Interfaces\Repositories;

use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Domain\Query\Entities\Query;
use ZnSandbox\Sandbox\I18n\Domain\Entities\TranslateEntity;

interface TranslateRepositoryInterface extends CrudRepositoryInterface
{

    public function findOneByEntity(int $entityTypeId, int $entityId, int $languageId, Query $query = null): TranslateEntity;
}
