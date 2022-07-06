<?php

namespace ZnSandbox\Sandbox\Synchronize;

use ZnCore\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function deps(): array
    {
        return [
            \ZnDatabase\Fixture\Bundle::class,
        ];
    }

    public function symfonyAdmin(): array
    {
        return [
            __DIR__ . '/Symfony4/Admin/config/routing.php',
        ];
    }
    
    public function yiiAdmin(): array
    {
        return [
            'modules' => [
                'synchronize' => __NAMESPACE__ . '\Yii2\Admin\Module',
            ],
        ];
    }

    public function i18next(): array
    {
        return [
            'synchronize' => 'vendor/znsandbox/sandbox/src/Synchronize/Domain/i18next/__lng__/__ns__.json',
        ];
    }
    
    /*public function migration(): array
    {
        return [
            '/src/Library/Domain/Migrations',
        ];
    }*/

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
