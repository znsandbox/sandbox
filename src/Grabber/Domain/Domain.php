<?php

namespace ZnSandbox\Sandbox\Grabber\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'grabber';
    }
}
