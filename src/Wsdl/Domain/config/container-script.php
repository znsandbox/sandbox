<?php

use ZnSandbox\Sandbox\Wsdl\Domain\Interfaces\Repositories\ClientRepositoryInterface;
use ZnSandbox\Sandbox\Wsdl\Domain\Libs\SoapHandler;
use Psr\Container\ContainerInterface;


use ZnCore\Base\Env\Helpers\EnvHelper;
use ZnCore\Base\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerConfiguratorInterface;
use ZnCore\Domain\EntityManager\Interfaces\EntityManagerInterface;

return function (ContainerConfiguratorInterface $configurator, EntityManagerConfiguratorInterface $em) {
    $configurator->importFromDir([__DIR__ . '/../..']);
    $isNullDriver = EnvHelper::isTest() || EnvHelper::isDev();
    if($isNullDriver) {
        $configurator->singleton(ClientRepositoryInterface::class, 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Repositories\\Null\\ClientRepository');
    } else {
        $configurator->singleton(ClientRepositoryInterface::class, 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Repositories\\Wsdl\\ClientRepository');
    }

//    $configurator->singleton(SoapHandler::class, function(ContainerInterface $container) {
//        /** @var SoapHandler $soapHandler */
//        $soapHandler = new SoapHandler($container);
//        $soapHandler->setDefinitionFile(__DIR__ . '/../../../Message/Wsdl/config/wsdl/AsyncChannel/v10/Interfaces/AsyncChannelHttp_Service.wsdl');
//        $soapHandler->addService(SendMessageController::class);
//        return $soapHandler;
//    });

//    $em->bindEntity('', '');
};







//return [
//	'singletons' => [
//        'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Interfaces\\Repositories\\ClientRepositoryInterface' => EnvHelper::isTest()
//            ? 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Repositories\\Null\\ClientRepository'
//            : 'ZnSandbox\\Sandbox\\Wsdl\\Domain\\Repositories\\Wsdl\\ClientRepository'
//        ,
//		SoapHandler::class => function(ContainerInterface $container) {
//            /** @var SoapHandler $soapHandler */
//            $soapHandler = new SoapHandler($container);
//            $soapHandler->setDefinitionFile(__DIR__ . '/../../../Message/Wsdl/config/wsdl/AsyncChannel/v10/Interfaces/AsyncChannelHttp_Service.wsdl');
//            $soapHandler->addService(SendMessageController::class);
//            return $soapHandler;
//        },
//	],
//];
