<?php

namespace ZnSandbox\Sandbox\Rpc\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'rpc';
    }


}
