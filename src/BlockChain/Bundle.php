<?php

namespace ZnSandbox\Sandbox\BlockChain;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function symfonyRpc(): array
    {
        return [
            __DIR__ . '/Rpc/config/routes.php',
        ];
    }
    
    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/BlockChain/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
