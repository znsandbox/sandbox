<?php

namespace ZnSandbox\Web\Base;

use ZnCore\Base\Helpers\StringHelper;
use ZnSandbox\Web\Interfaces\WidgetInterface;

abstract class BaseWidget implements WidgetInterface
{

    abstract public function render(): string;

    protected function renderTemplate(string $templateCode, array $params)
    {
        return StringHelper::renderTemplate($templateCode, $params);
    }
}