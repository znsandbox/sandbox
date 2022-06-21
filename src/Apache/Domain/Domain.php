<?php

namespace ZnSandbox\Sandbox\Apache\Domain;

use ZnCore\Base\Libs\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'apache';
    }

}
