<?php

namespace ZnSandbox\Sandbox\UserNotify;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function yiiAdmin(): array
    {
        return [
            'modules' => [
                'notify' => __NAMESPACE__ . '\Yii2\Admin\Module',
            ],
        ];
    }

    public function i18next(): array
    {
        return [
            'notify' => '/vendor/znsandbox/sandbox/src/UserNotify/Domain/i18next/__lng__/__ns__.json',
        ];
    }

    public function migration(): array
    {
        return [
            '/Packages/Notify/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
