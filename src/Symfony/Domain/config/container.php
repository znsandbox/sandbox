<?php

use Psr\Container\ContainerInterface;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Twig\RuntimeLoader\FactoryRuntimeLoader;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnBundle\User\Domain\Services\AuthService3;
use ZnBundle\User\Domain\Subscribers\SymfonyAuthenticationIdentitySubscriber;

return [
	'definitions' => [
	    
    ],
	'singletons' => [
        'ZnBundle\Notify\Domain\Interfaces\Repositories\ToastrRepositoryInterface' => 'ZnBundle\Notify\Domain\Repositories\Symfony\ToastrRepository',
        'ZnBundle\\Language\\Domain\\Interfaces\\Repositories\\SwitchRepositoryInterface' => 'ZnBundle\\Language\\Domain\\Repositories\\Symfony4\\SwitchRepository',
        'ZnBundle\\Language\\Domain\\Interfaces\\Repositories\\StorageRepositoryInterface' => 'ZnBundle\\Language\\Domain\\Repositories\\Symfony4\\StorageRepository',

        \Symfony\Component\HttpKernel\Controller\ControllerResolverInterface::class => \ZnLib\Web\Symfony4\HttpKernel\ControllerResolver::class,
        \Symfony\Component\Routing\Generator\UrlGeneratorInterface::class => \Symfony\Component\Routing\Generator\UrlGenerator::class,

            TokenStorageInterface::class => function(ContainerInterface $container) {
            $session = $container->get(SessionInterface::class);
            return new SessionTokenStorage($session);
        },

        SessionInterface::class => Session::class,
        CsrfTokenManagerInterface::class => CsrfTokenManager::class,
        RuntimeLoaderInterface::class => FactoryRuntimeLoader::class,
        FormFactoryInterface::class => FormFactory::class,
        FormRegistryInterface::class => function(ContainerInterface $container) {
            $registry = new FormRegistry(
                [$container->get(HttpFoundationExtension::class)],
                $container->get(ResolvedFormTypeFactory::class)
            );
            return $registry;
        },
        AuthServiceInterface::class => function(ContainerInterface $container) {
            /** @var AuthService3 $authService */
            $authService = $container->get(AuthService3::class);
            $authService->addSubscriber(SymfonyAuthenticationIdentitySubscriber::class);
            $authService->addSubscriber([
                'class' => \ZnBundle\User\Domain\Subscribers\AuthenticationAttemptSubscriber::class,
                'action' => 'authorization',
                // todo: вынести в настройки
                'attemptCount' => 3,
                'lifeTime' => 10,
//                'lifeTime' => TimeEnum::SECOND_PER_MINUTE * 30,
            ]);
            return $authService;
        },
	],
	'entities' => [
		
	],
];
