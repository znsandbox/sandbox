<?php

namespace ZnSandbox\Sandbox\Bundle\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'bundle';
    }


}

