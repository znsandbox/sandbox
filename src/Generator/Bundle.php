<?php

namespace ZnSandbox\Sandbox\Generator;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function console(): array
    {
        return [
            'ZnSandbox\Sandbox\Generator\Commands',
        ];
    }

    /*public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }*/
}
