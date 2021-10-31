<?php

namespace ZnSandbox\Sandbox\Symfony;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class NewBundle extends BaseBundle
{

    public function deps(): array
    {
        return [

        ];
    }
    
    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/new-container.php',
        ];
    }
}
