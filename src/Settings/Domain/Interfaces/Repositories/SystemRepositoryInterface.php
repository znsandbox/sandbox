<?php

namespace ZnSandbox\Sandbox\Settings\Domain\Interfaces\Repositories;

use ZnSandbox\Sandbox\Settings\Domain\Entities\SystemEntity;
use Illuminate\Support\Collection;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;

interface SystemRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param string $name
     * @return Collection | SystemEntity[]
     */
    public function allByName(string $name): Collection;
}
