<?php

namespace ZnSandbox\Sandbox\Geo\Rpc\Controllers;

use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Services\CurrencyServiceInterface;

class CurrencyController extends BaseCrudRpcController
{

    public function __construct(CurrencyServiceInterface $service)
    {
        $this->service = $service;
    }
}
