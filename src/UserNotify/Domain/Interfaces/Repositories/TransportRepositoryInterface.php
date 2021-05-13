<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories;

use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;

interface TransportRepositoryInterface extends CrudRepositoryInterface
{

    public function allByTypeId(int $typeId): Collection;
}
