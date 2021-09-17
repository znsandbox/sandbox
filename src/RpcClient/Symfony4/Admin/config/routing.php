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
    $routes
        ->add('rpc-client/request/clear-history', '/rpc-client/request/clear-history')
        ->controller([\ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers\ClientController::class, 'clearHistory'])
        ->methods(['GET', 'POST']);
    $routes
        ->add('rpc-client/tool/import-from-routes', '/rpc-client/tool/import-from-routes')
        ->controller([\ZnSandbox\Sandbox\RpcClient\Symfony4\Admin\Controllers\ToolController::class, 'importFromRoutes'])
        ->methods(['GET', 'POST']);
    
    
    //    RouteHelper::generateCrud($routes, ApplicationController::class, '/application/application');
//    RouteHelper::generateCrud($routes, ApiKeyController::class, '/application/api-key');
//    RouteHelper::generateCrud($routes, EdsController::class, '/application/eds');
};
