<?php

namespace ZnSandbox\Sandbox\App\Base;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnLib\Rpc\Symfony4\HttpKernel\RpcFramework;
use ZnSandbox\Sandbox\App\Subscribers\WebDetectTestEnvSubscriber;

abstract class BaseRpcApp extends BaseApp
{

    public function appName(): string
    {
        return 'rpc';
    }

    public function subscribes(): array
    {
        return [
            WebDetectTestEnvSubscriber::class,
        ];
    }

    public function import(): array
    {
        return ['i18next', 'container', 'symfonyRpc'];
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
        $containerConfigurator->singleton(HttpKernelInterface::class, RpcFramework::class);
    }

    protected function configDispatcher(EventDispatcherInterface $dispatcher): void
    {
        //$dispatcher->addSubscriber($this->container->get(RpcFirewallSubscriber::class));
    }
}
