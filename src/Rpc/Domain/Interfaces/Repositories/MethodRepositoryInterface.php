<?php

namespace ZnSandbox\Sandbox\Rpc\Domain\Interfaces\Repositories;

use ZnSandbox\Sandbox\Rpc\Domain\Entities\MethodEntity;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Interfaces\Repository\CrudRepositoryInterface;

interface MethodRepositoryInterface extends \ZnLib\Rpc\Domain\Interfaces\Repositories\MethodRepositoryInterface //CrudRepositoryInterface
{

    /**
     * @param string $method
     * @param int $version
     * @return MethodEntity
     */
//    public function oneByMethodName(string $method, int $version): MethodEntity;
}
