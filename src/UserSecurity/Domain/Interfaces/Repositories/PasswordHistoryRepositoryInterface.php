<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Interfaces\Repositories;

use ZnSandbox\Sandbox\UserSecurity\Domain\Entities\PasswordHistoryEntity;
use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;

interface PasswordHistoryRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param int $identityId
     * @return Collection | PasswordHistoryEntity[]
     */
    public function allByIdentityId(int $identityId): Collection;
}

