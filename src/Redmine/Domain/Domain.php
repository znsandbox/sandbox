<?php

namespace ZnSandbox\Sandbox\Redmine\Domain;

use ZnCore\Domain\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'redmine';
    }
}
