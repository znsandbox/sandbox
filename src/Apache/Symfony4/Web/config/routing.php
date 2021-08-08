<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use ZnSandbox\Sandbox\Apache\Symfony4\Web\Controllers\ServerController;

return function (RoutingConfigurator $routes) {
    $routes
        ->add('server_index', '/apache')
        ->controller([ServerController::class, 'index']);
    $routes
        ->add('server_view', '/apache/view')
        ->controller([ServerController::class, 'view']);
};
