<?php

namespace ZnSandbox\Sandbox\Contact\Domain;

use ZnCore\Domain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'contact';
    }

}