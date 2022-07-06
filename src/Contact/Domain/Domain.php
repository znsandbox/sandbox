<?php

namespace ZnSandbox\Sandbox\Contact\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'contact';
    }

}