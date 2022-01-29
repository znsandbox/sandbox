<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'blockchain';
    }

}
