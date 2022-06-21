<?php

namespace ZnSandbox\Sandbox\Person2\Domain;

use ZnCore\Base\Libs\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'person';
    }
}
