<?php

namespace ZnUser\Rbac\Rpc\Controllers;

use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnUser\Rbac\Domain\Interfaces\Services\RoleServiceInterface;

class RoleController extends BaseCrudRpcController
{

    public function __construct(RoleServiceInterface $service)
    {
        $this->service = $service;
    }
}
