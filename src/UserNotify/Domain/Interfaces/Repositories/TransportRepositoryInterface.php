<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories;

use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TransportEntity;

interface TransportRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param int $typeId
     * @return Collection|array|TransportEntity[]
     */
    public function allEnabledByTypeId(int $typeId): Collection;
}
