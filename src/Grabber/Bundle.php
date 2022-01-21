<?php

namespace ZnSandbox\Sandbox\Grabber;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function console(): array
    {
        return [
            'ZnSandbox\Sandbox\Grabber\Commands',
        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/Grabber/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
