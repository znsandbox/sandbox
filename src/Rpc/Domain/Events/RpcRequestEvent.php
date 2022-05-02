<?php

namespace ZnLib\Rpc\Domain\Events;

use ZnLib\Rpc\Domain\Entities\MethodEntity;
use Symfony\Contracts\EventDispatcher\Event;
use ZnCore\Domain\Traits\Event\EventSkipHandleTrait;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;

class RpcRequestEvent extends Event
{

    use EventSkipHandleTrait;

    private $requestEntity;
    private $methodEntity;

    public function __construct(RpcRequestEntity $requestEntity, MethodEntity $methodEntity)
    {
        $this->requestEntity = $requestEntity;
        $this->methodEntity = $methodEntity;
    }

    public function getRequestEntity(): RpcRequestEntity
    {
        return $this->requestEntity;
    }

    public function getMethodEntity(): MethodEntity
    {
        return $this->methodEntity;
    }
}
