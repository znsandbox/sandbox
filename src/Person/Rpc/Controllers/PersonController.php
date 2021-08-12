<?php

namespace ZnSandbox\Sandbox\Person\Rpc\Controllers;

use ZnSandbox\Sandbox\Person\Domain\Interfaces\Services\PersonServiceInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;

class PersonController extends BaseCrudRpcController
{

    public function __construct(PersonServiceInterface $personService)
    {
        $this->service = $personService;
    }

    public function oneById(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $rpcMethod = $requestEntity->getMethod();
        $entityName = explode('.', $rpcMethod)[0];
        $id = $requestEntity->getParamItem('id');

        $entity = $this->service->oneById($entityName, $id);
        $data = EntityHelper::toArray($entity);

        $response = new RpcResponseEntity();
        $response->setResult($data);
        return $response;
    }
}
