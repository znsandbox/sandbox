<?php

namespace ZnSandbox\Sandbox\App\Base;

abstract class BaseAdminApp extends BaseWebApp
{

    public function appName(): string
    {
        return 'admin';
    }

    public function import(): array
    {
        return ['i18next', 'container', 'symfonyAdmin'];
    }
}
