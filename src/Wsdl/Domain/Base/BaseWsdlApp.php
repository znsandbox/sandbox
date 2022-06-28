<?php

namespace ZnSandbox\Sandbox\Wsdl\Domain\Base;

use ZnLib\Web\WebApp\Base\BaseWebApp;

abstract class BaseWsdlApp extends BaseWebApp
{

    public function appName(): string
    {
        return 'wsdl';
    }
}
