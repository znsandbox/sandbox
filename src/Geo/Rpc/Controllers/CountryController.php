<?php

namespace ZnSandbox\Sandbox\Geo\Rpc\Controllers;

use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Services\CountryServiceInterface;

class CountryController extends BaseCrudRpcController
{

    public function __construct(CountryServiceInterface $service)
    {
        $this->service = $service;
    }
}
