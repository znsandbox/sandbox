<?php

namespace ZnSandbox\Sandbox\Symfony;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function deps(): array
    {
        return [
            new \ZnCore\Base\Bundle(['all']),
            new \ZnCore\Base\Libs\I18Next\Bundle(['all']),
            new \ZnCore\Base\Libs\App\Bundle(['all']),
        ];
    }
    
    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
