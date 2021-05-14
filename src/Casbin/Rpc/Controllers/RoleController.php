<?php

namespace ZnSandbox\Sandbox\Casbin\Rpc\Controllers;

use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\RoleServiceInterface;

class RoleController extends BaseCrudRpcController
{

    public function __construct(RoleServiceInterface $service)
    {
        $this->service = $service;
    }
}
