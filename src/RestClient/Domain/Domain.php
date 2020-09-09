<?php

namespace ZnSandbox\Sandbox\RestClient\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'restClient';
    }


}

