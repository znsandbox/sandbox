<?php

namespace ZnSandbox\Sandbox\Layout\Domain;

use ZnCore\Base\Libs\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'layout';
    }
}
