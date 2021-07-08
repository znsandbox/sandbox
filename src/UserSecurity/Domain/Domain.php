<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'security';
    }


}

