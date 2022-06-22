<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain;

use ZnCore\Domain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'rpc-client';
    }


}

