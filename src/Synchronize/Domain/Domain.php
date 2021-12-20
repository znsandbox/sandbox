<?php

namespace ZnSandbox\Sandbox\Synchronize\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'tools';
    }
}
