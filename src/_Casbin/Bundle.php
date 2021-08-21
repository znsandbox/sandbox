<?php

namespace ZnUser\Rbac;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    /*public function deps(): array
    {
        return [
            new \ZnBundle\User\NewBundle(['all']),
        ];
    }*/

    public function symfonyRpc(): array
    {
        return [
            __DIR__ . '/Rpc/config/assignment-routes.php',
            __DIR__ . '/Rpc/config/permission-routes.php',
            __DIR__ . '/Rpc/config/role-routes.php',
        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znuser/rbac/src/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
