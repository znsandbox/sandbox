<?php

use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnLib\Web\Symfony4\HttpKernel\ControllerResolver;
use ZnLib\Web\View\Resources\Css;
use ZnLib\Web\View\Resources\Js;
use ZnLib\Web\View\View;

DeprecateHelper::hardThrow();

return [
    'singletons' => [
        ControllerResolverInterface::class => ControllerResolver::class,
        View::class => View::class,
        Css::class => Css::class,
        Js::class => Js::class,
    ],
];
