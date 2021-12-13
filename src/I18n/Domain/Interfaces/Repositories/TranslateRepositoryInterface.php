<?php

namespace ZnSandbox\Sandbox\I18n\Domain\Interfaces\Repositories;

use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;
use ZnSandbox\Sandbox\I18n\Domain\Entities\TranslateEntity;

interface TranslateRepositoryInterface extends CrudRepositoryInterface
{

    public function oneByUnique(int $entityTypeId, int $entityId, int $languageId, Query $query = null): TranslateEntity;
}
