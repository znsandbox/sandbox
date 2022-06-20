<?php

namespace ZnSandbox\Sandbox\I18n\Domain\Interfaces\Repositories;

use ZnCore\Base\Libs\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Base\Libs\Query\Entities\Query;
use ZnSandbox\Sandbox\I18n\Domain\Entities\TranslateEntity;

interface TranslateRepositoryInterface extends CrudRepositoryInterface
{

    public function oneByEntity(int $entityTypeId, int $entityId, int $languageId, Query $query = null): TranslateEntity;
}
