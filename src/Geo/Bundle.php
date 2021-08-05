<?php

namespace ZnSandbox\Sandbox\Geo;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function yiiWeb(): array
    {
        return [
            'modules' => [
                'geo' => __NAMESPACE__ . '\Yii2\Web\Module',
            ],
        ];
    }

    public function yiiAdmin(): array
    {
        return [
            'modules' => [
                'geo' => __NAMESPACE__ . '\Yii2\Admin\Module',
            ],
        ];
    }

    public function i18next(): array
    {
        return [
            'geo' => 'Packages/Geo/Domain/i18next/__lng__/__ns__.json',
        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/Geo/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
