<?php

namespace ZnSandbox\Sandbox\Person2\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'person';
    }
}
