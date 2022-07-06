<?php

namespace ZnSandbox\Sandbox\Settings;

use ZnCore\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/Settings/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
