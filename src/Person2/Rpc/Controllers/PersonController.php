<?php

namespace ZnSandbox\Sandbox\Person2\Rpc\Controllers;

use ZnCore\Domain\Libs\Query;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnLib\Rpc\Rpc\Base\BaseRpcController;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;

class PersonController extends BaseCrudRpcController
{

    public function __construct(PersonServiceInterface $personService)
    {
        $this->service = $personService;
    }

    public function persist(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $params = $requestEntity->getParams();
        $entity = $this->service->persistEntity($params);
        return $this->serializeResult($entity);
    }

/*
    public function allowRelations(): array
    {
        return [
            'contacts',
            'contacts.attribute',
            'sex',
        ];
    }

    public function attributesExclude(): array
    {
        return [
            'id',
            'identityId',
//            'attributes',
        ];
    }

    public function one(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $query = new Query();
        $this->forgeWith($requestEntity, $query);
        $personEntity = $this->service->one($query);
        return $this->serializeResult($personEntity);
    }

    public function update(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $data = $requestEntity->getParams();
        $this->service->update($data);
        return $this->serializeResult(null);
    }*/
}
