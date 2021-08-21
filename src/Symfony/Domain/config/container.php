<?php

use App\Common\Enums\Rbac\ApplicationRoleEnum;
use ZnSandbox\Sandbox\Rpc\Symfony4\Web\Libs\CryptoProviderInterface;
use ZnSandbox\Sandbox\Rpc\Symfony4\Web\Libs\JsonDSigCryptoProvider;
use ZnBundle\Dashboard\Domain\Interfaces\Services\DashboardServiceInterface;
use ZnBundle\Dashboard\Domain\Services\DashboardService;
use ZnBundle\User\Domain\Subscribers\AuthenticationAttemptSubscriber;
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
use ZnCrypt\Pki\Domain\Helpers\RsaKeyLoaderHelper;
use ZnLib\Web\Widgets\BreadcrumbWidget;
use ZnUser\Rbac\Domain\Interfaces\Services\ManagerServiceInterface;
use ZnUser\Rbac\Domain\Services\ManagerService;

return [
	'definitions' => [
	    
    ],
	'singletons' => [
        'ZnBundle\Notify\Domain\Interfaces\Repositories\ToastrRepositoryInterface' => 'ZnBundle\Notify\Domain\Repositories\Symfony\ToastrRepository',
        'ZnBundle\\Language\\Domain\\Interfaces\\Repositories\\SwitchRepositoryInterface' => 'ZnBundle\\Language\\Domain\\Repositories\\Symfony4\\SwitchRepository',
        'ZnBundle\\Language\\Domain\\Interfaces\\Repositories\\StorageRepositoryInterface' => 'ZnBundle\\Language\\Domain\\Repositories\\Symfony4\\StorageRepository',

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
                'class' => AuthenticationAttemptSubscriber::class,
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
