<?php

use ZnSandbox\Sandbox\UserSecurity\Symfony4\Web\Controllers\RestorePasswordController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes
        ->add('restore-password/request-activation-code', '/restore-password')
        ->controller([RestorePasswordController::class, 'requestActivationCode'])
        ->methods(['GET', 'POST']);
    $routes
        ->add('restore-password/create-password', '/restore-password/create-password')
        ->controller([RestorePasswordController::class, 'createPassword'])
        ->methods(['GET', 'POST']);
};
