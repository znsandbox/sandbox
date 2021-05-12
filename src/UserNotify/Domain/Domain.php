<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'notify';
    }
}
