<?php

namespace ZnSandbox\Sandbox\Wsdl;

use ZnCore\Base\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function symfonyWeb(): array
    {
        return [
            __DIR__ . '/Symfony/Web/config/routing.php',
        ];
    }

    public function i18next(): array
    {
        return [

        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znsandbox/sandbox/src/Wsdl/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
            __DIR__ . '/Domain/config/container-script.php',
        ];
    }
}
