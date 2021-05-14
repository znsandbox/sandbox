<?php

namespace ZnSandbox\Sandbox\Casbin\Rpc\Controllers;

use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\PermissionServiceInterface;

class PermissionController extends BaseCrudRpcController
{

    public function __construct(PermissionServiceInterface $service)
    {
        $this->service = $service;
    }
}
