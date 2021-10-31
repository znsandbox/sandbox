<?php

namespace ZnSandbox\Sandbox\App\Apps;

abstract class AdminApp extends WebApp
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
