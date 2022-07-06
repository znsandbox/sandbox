<?php

namespace ZnSandbox\Sandbox\I18n;

use ZnCore\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/I18n/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
