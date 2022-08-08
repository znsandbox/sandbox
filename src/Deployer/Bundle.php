<?php

namespace ZnSandbox\Sandbox\Deployer;

use ZnCore\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function console(): array
    {
        return [
            'ZnSandbox\Sandbox\Deployer\Commands',
        ];
    }

    /*public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }*/
}
