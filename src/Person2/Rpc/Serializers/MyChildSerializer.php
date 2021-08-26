<?php

namespace ZnSandbox\Sandbox\Person2\Rpc\Serializers;

use ZnLib\Rpc\Rpc\Serializers\DefaultSerializer;
use ZnSandbox\Sandbox\Person2\Domain\Entities\InheritanceEntity;

class MyChildSerializer extends DefaultSerializer
{

    protected function encodeEntity(object $entity)
    {
        /** @var InheritanceEntity $entity */
        return parent::encodeEntity($entity->getChildPerson());
    }
}
