<?php

namespace ZnSandbox\Sandbox\Layout\Domain;

use ZnCore\Domain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'layout';
    }
}
