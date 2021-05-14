<?php

namespace ZnSandbox\Sandbox\Casbin\Rpc\Controllers;

use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Services\ItemServiceInterface;

class ItemController extends BaseCrudRpcController
{

    public function __construct(ItemServiceInterface $service)
    {
        $this->service = $service;
    }
}
