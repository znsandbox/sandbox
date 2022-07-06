<?php

namespace ZnSandbox\Sandbox\Person2\Rpc\Controllers;

use ZnBundle\Eav\Domain\Interfaces\Services\EntityServiceInterface;
use ZnCore\Query\Entities\Query;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\ContactServiceInterface;

class ContactController extends BaseCrudRpcController
{

    private $eavEntityService;

    public function __construct(ContactServiceInterface $contactService, EntityServiceInterface $eavEntityService)
    {
        $this->service = $contactService;
        $this->eavEntityService = $eavEntityService;
    }

    public function allowRelations(): array
    {
        return [
            'attribute'
        ];
    }

    public function attributesOnly(): array
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
    }

    public function allByPersonId(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $params = $requestEntity->getParams();
        $collection = $this->service->allByPersonId($params['personId']);
        return $this->serializeResult($collection);
    }
}
