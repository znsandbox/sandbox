<?php

namespace ZnSandbox\Sandbox\Synchronize\Domain;

use ZnDomain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'synchronize';
    }
}
