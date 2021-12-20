<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes
        ->add('synchronize/synchronize/index', '/synchronize/synchronize')
        ->controller([\ZnSandbox\Sandbox\Synchronize\Symfony4\Admin\Controllers\SynchronizeController::class, 'index'])
        ->methods(['GET', 'POST']);
};
