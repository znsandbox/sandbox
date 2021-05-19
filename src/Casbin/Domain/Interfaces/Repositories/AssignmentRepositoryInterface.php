<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories;

use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;

interface AssignmentRepositoryInterface extends CrudRepositoryInterface
{

    public function allByIdentityId(int $identityId): Collection;
}

