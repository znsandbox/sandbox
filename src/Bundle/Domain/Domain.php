<?php

namespace ZnSandbox\Sandbox\Bundle\Domain;

use ZnCore\Base\Libs\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'bundle';
    }


}

