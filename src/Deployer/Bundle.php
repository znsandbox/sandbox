<?php

namespace ZnSandbox\Sandbox\Deployer;

use ZnCore\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function deps(): array
    {
        return [
            \ZnLib\Components\ShellRobot\Bundle::class,
        ];
    }

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
