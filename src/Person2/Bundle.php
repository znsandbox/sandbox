<?php

namespace ZnSandbox\Sandbox\Person2;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    /*public function symfonyRpc(): array
    {
        return [
            __DIR__ . '/Rpc/config/routes.php',
        ];
    }*/

    /*public function symfonyWeb(): array
    {
        return [
            __DIR__ . '/Symfony4/Web/config/routing.php',
        ];
    }*/

    /*public function i18next(): array
    {
        return [
            'app_user' => 'src/User/Domain/i18next/__lng__/__ns__.json',
        ];
    }*/

    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/Person2/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}