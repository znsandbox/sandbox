<?php

namespace ZnSandbox\Sandbox\Synchronize\Domain;

use ZnCore\Domain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'synchronize';
    }
}
