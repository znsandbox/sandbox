<?php

namespace ZnSandbox\Sandbox\UserSecurity;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    /*public function i18next(): array
    {
        return [
            'app_user' => 'src/User/Domain/i18next/__lng__/__ns__.json',
        ];
    }*/

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
