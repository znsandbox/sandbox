<?php

namespace ZnSandbox\Sandbox\Organization\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'organization';
    }


}

