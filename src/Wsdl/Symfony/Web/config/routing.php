<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use ZnSandbox\Sandbox\Wsdl\Symfony\Web\Controllers\WsdlController;

return function (RoutingConfigurator $routes) {
    /*$routes
        ->add('main_page', '/')
        ->controller([DefaultController::class, 'index']);*/
    $routes
        ->add('wsdl_docs', '/wsdl')
        ->controller([WsdlController::class, 'showDocs'])
        ->methods(['GET']);

    $routes
        ->add('wsdl_call_procedure', '/wsdl')
        ->controller([WsdlController::class, 'callProcedure'])
        ->methods(['POST']);
};
