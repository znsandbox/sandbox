<?php

namespace ZnSandbox\Sandbox\UserSecurity;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function i18next(): array
    {
        return [
            'user_security' => 'vendor/znsandbox/sandbox/src/UserSecurity/Domain/i18next/__lng__/__ns__.json',
        ];
    }

    public function symfonyRpc(): array
    {
        return [
            __DIR__ . '/Rpc/config/routes.php',
        ];
    }

    public function symfonyWeb(): array
    {
        return [
            __DIR__ . '/Symfony4/Web/config/routing.php',
        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/UserSecurity/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
