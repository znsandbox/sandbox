<?php

namespace ZnSandbox\Sandbox\Wsdl\Domain;

use ZnCore\Domain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'wsdl';
    }
}
