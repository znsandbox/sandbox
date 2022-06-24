<?php

namespace ZnSandbox\Sandbox\Redmine;

use ZnCore\Base\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/Redmine/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
