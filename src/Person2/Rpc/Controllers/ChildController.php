<?php

namespace ZnSandbox\Sandbox\Person2\Rpc\Controllers;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\Container\ContainerAwareTrait;
use ZnLib\Rpc\Rpc\Base\BaseCrudRpcController;
use ZnLib\Rpc\Rpc\Serializers\SerializerInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\ChildServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\MyChildServiceInterface;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Services\PersonServiceInterface;
use ZnSandbox\Sandbox\Person2\Rpc\Serializers\MyChildSerializer;

class ChildController extends BaseCrudRpcController
{

    use ContainerAwareTrait;

    private $personService;

    public function __construct(
        ChildServiceInterface $childService,
        PersonServiceInterface $personService,
        ContainerInterface $container
    )
    {
        $this->service = $childService;
        $this->personService = $personService;
        $this->setContainer($container);
    }

    public function serializer(): SerializerInterface
    {
        return $this->getContainer()->get(MyChildSerializer::class);
    }
}
