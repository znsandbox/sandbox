<?php

namespace ZnSandbox\Sandbox\Settings\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'settings';
    }
}
