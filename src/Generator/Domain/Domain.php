<?php

namespace ZnSandbox\Sandbox\Generator\Domain;

use ZnCore\Domain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'generator';
    }


}

