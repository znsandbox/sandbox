<?php

namespace ZnSandbox\Sandbox\Settings\Domain\Interfaces\Repositories;

use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnSandbox\Sandbox\Settings\Domain\Entities\SystemEntity;

interface SystemRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param string $name
     * @return Enumerable | SystemEntity[]
     */
    public function allByName(string $name): Enumerable;
}
