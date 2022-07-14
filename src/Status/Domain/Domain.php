<?php

namespace ZnSandbox\Sandbox\Status\Domain;

use ZnDomain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'utility';
    }
}
