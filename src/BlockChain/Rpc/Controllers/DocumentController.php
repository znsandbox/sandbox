<?php

namespace ZnSandbox\Sandbox\BlockChain\Rpc\Controllers;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\Container\ContainerAwareTrait;
use ZnCore\Domain\Libs\Query;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;
use ZnLib\Rpc\Domain\Entities\RpcResponseEntity;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnLib\Rpc\Rpc\Serializers\SerializerInterface;
use ZnSandbox\Sandbox\Person2\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyChildServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;
use ZnSandbox\Sandbox\Person2\Rpc\Serializers\MyChildSerializer;

class DocumentController extends BaseCrudRpcController
{

    use ContainerAwareTrait;

    /*private $personService;

    public function __construct(
        MyChildServiceInterface $myChildService,
        PersonServiceInterface $personService,
        ContainerInterface $container
    )
    {
        $this->service = $myChildService;
        $this->personService = $personService;
        $this->setContainer($container);
    }*/

    public function send(RpcRequestEntity $requestEntity): RpcResponseEntity
    {
        $document = $requestEntity->getParamItem('document');
        
        return $this->serializeResult([$document]);
    }
}
