<?php

namespace ZnSandbox\Sandbox\Status\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'utility';
    }
}
