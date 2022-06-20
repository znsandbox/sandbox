<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories;

use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;
use ZnCore\Base\Libs\Query\Entities\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;

interface PersonRepositoryInterface
{

    public function oneByIdentityId(int $identityId, Query $query = null): PersonEntity;

}

