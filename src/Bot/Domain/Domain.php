<?php

namespace ZnSandbox\Sandbox\Bot\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'bot';
    }


}

