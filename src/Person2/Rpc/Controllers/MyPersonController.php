<?php

namespace ZnSandbox\Sandbox\Person2\Rpc\Controllers;

use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseRpcController;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

class MyPersonController extends BaseRpcController
{

    public function __construct(MyPersonServiceInterface $personService)
    {
        $this->service = $personService;
    }

    public function attributesExclude(): array
    {
        return [
            'id',
            'identityId',
            'attributes',
        ];
    }

    public function one(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $personEntity = $this->service->one();
        return $this->serializeResult($personEntity);
    }

    public function update(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $data = $requestEntity->getParams();
        $this->service->update($data);
        return $this->serializeResult(null);
    }
}
