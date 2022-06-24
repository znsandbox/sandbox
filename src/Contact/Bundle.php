<?php

namespace ZnSandbox\Sandbox\Contact;

use ZnCore\Base\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/Contact/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
