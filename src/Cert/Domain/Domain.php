<?php

namespace ZnSandbox\Sandbox\Cert\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'apache';
    }

}
