<?php

namespace ZnSandbox\Sandbox\UserRegistration\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'userRegistration';
    }
}
