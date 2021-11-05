<?php

namespace ZnSandbox\Sandbox\Person2\Rpc\Controllers;

use ZnCore\Domain\Libs\Query;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnLib\Rpc\Rpc\Serializers\SerializerInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyChildServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;
use ZnSandbox\Sandbox\Person2\Rpc\Serializers\MyChildSerializer;

class MyChildController extends BaseCrudRpcController
{
    private $personService;

    public function __construct(MyChildServiceInterface $myChildService, PersonServiceInterface $personService)
    {
        $this->service = $myChildService;
        $this->personService = $personService;
    }

    public function serializer(): SerializerInterface
    {
        return new MyChildSerializer();
    }

    /*public function allowRelations(): array
    {
        return [
            'child_person',
            'parent_person',
        ];
    }*/

    protected function forgeWith(RpcRequestEntity $requestEntity, Query $query)
    {
        $query->with(['child_person']);
        parent::forgeWith($requestEntity, $query);
    }

    public function update(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $id = $requestEntity->getParamItem('id');
        $data = $requestEntity->getParams();

        unset($data['id']);

        $this->personService->updateById($id, $data);

        return new RpcResponseEntity();
    }

    /*public function add(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        return parent::add($requestEntity);
    }

    public function update(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        return parent::update($requestEntity);
    }

    public function delete(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        return parent::delete($requestEntity);
    }*/

    /*public function attributesOnly(): array
    {
        return [
            'id',
            'value',
            'attributeId',
            'attribute.id',
            'attribute.name',
            'attribute.title',
            'attribute.description',
        ];
    }*/
}
