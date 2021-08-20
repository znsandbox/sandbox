<?php

namespace ZnSandbox\Sandbox\Person2\Rpc\Controllers;

use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyContactServiceInterface;

class MyContactController extends BaseCrudRpcController
{

    public function __construct(MyContactServiceInterface $myContactService)
    {
        $this->service = $myContactService;
    }

    public function allowRelations(): array
    {
        return ['attribute'];
    }

    public function attributesOnly(): array
    {
        return [
            'id',
            'value',
//            'attributeId',
            'attribute.id',
            'attribute.name',
            'attribute.title',
            'attribute.description',
        ];
    }
}
