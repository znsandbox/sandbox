<?php

namespace ZnSandbox\Sandbox\Office;

use ZnCore\Base\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
