<?php

namespace ZnSandbox\Sandbox\Person2\Rpc\Controllers;

use ZnBundle\User\Domain\Interfaces\Services\IdentityServiceInterface;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnLib\Rpc\Rpc\Base\BaseRpcController;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyContactServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyPersonServiceInterface;

class MyContactController extends BaseCrudRpcController
{

    public function __construct(MyContactServiceInterface $myContactService)
    {
        $this->service = $myContactService;
    }

    public function attributesExclude(): array
    {
        return [
           /* 'id',
            'identityId',
            'attributes',*/
        ];
    }

    /*public function one(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $personEntity = $this->service->one();
        return $this->serializeResult($personEntity);
    }

    public function update(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $data = $requestEntity->getParams();
        $this->service->update($data);
        return $this->serializeResult(null);
    }*/
}
