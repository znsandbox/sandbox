<?php

namespace ZnSandbox\Sandbox\Settings\Domain\Interfaces\Repositories;

use ZnSandbox\Sandbox\Settings\Domain\Entities\SystemEntity;
use ZnCore\Domain\Collection\Libs\Collection;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;

interface SystemRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param string $name
     * @return \ZnCore\Domain\Collection\Interfaces\Enumerable | SystemEntity[]
     */
    public function allByName(string $name): Collection;
}
