<?php

namespace ZnSandbox\Sandbox\Settings\Domain\Interfaces\Repositories;

use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnSandbox\Sandbox\Settings\Domain\Entities\SystemEntity;
use ZnCore\Domain\Collection\Libs\Collection;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;

interface SystemRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param string $name
     * @return Enumerable | SystemEntity[]
     */
    public function allByName(string $name): Enumerable;
}
