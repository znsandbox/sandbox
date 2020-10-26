<?php

namespace ZnSandbox\Sandbox\Apache\Symfony4\Web;

use Illuminate\Container\Container;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use ZnLib\Init\Domain\Interfaces\Repositories\LockerRepositoryInterface;
use ZnLib\Init\Domain\Interfaces\Repositories\RequirementRepositoryInterface;
use ZnLib\Init\Domain\Repositories\File\LockerRepository;
use ZnLib\Init\Domain\Repositories\File\RequirementRepository;
use ZnSandbox\Sandbox\Apache\Domain\Repositories\Conf\ServerRepository;
use ZnSandbox\Sandbox\Apache\Symfony4\Web\Controllers\InitController;
use ZnLib\Web\Symfony4\MicroApp\BaseModule;

class InitModule extends BaseModule
{

    public function configContainer(Container $container)
    {
        $container->bind(ServerRepository::class, function () {
            return new ServerRepository($_ENV['HOST_CONF_DIR']);
        }, true);
    }

    public function configRoutes(RouteCollection $routes)
    {
        $routes->add('init_index', new Route('/', [
            '_controller' => InitController::class,
            '_action' => 'index',
        ]));
        /*$routes->add('init_env', new Route('/env', [
            '_controller' => InitController::class,
            '_action' => 'env',
        ]));
        $routes->add('init_install', new Route('/install', [
            '_controller' => InitController::class,
            '_action' => 'install',
        ]));*/
    }
}
