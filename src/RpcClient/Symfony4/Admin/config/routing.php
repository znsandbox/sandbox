<?php

use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers\ApplicationController;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers\EdsController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers\ApiKeyController;
use ZnLib\Web\Symfony4\MicroApp\Helpers\RouteHelper;

return function (RoutingConfigurator $routes) {
    $routes
        ->add('rpc-client/request', '/rpc-client/request')
        ->controller([\ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers\ClientController::class, 'request'])
        ->methods(['GET', 'POST']);
    
    
    
    //    RouteHelper::generateCrud($routes, ApplicationController::class, '/application/application');
//    RouteHelper::generateCrud($routes, ApiKeyController::class, '/application/api-key');
//    RouteHelper::generateCrud($routes, EdsController::class, '/application/eds');
};
