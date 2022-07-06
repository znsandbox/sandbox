<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories;

use ZnCore\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Query\Entities\Query;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;

interface PersonRepositoryInterface
{

    public function findOneByIdentityId(int $identityId, Query $query = null): PersonEntity;

}

