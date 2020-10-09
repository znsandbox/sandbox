<?php

namespace ZnSandbox\Sandbox\Eav\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'eav';
    }

}
