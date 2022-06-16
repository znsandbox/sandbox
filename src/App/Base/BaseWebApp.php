<?php

namespace ZnSandbox\Sandbox\App\Base;

use Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\Event\Interfaces\EventDispatcherConfiguratorInterface;
use ZnSandbox\Sandbox\App\Subscribers\ErrorHandleSubscriber;
use ZnSandbox\Sandbox\App\Subscribers\FindRouteSubscriber;
use ZnSandbox\Sandbox\App\Subscribers\WebDetectTestEnvSubscriber;
use ZnSandbox\Sandbox\App\Subscribers\WebFirewallSubscriber;
use ZnLib\Web\View\View;
use ZnSandbox\Sandbox\App\Base\BaseApp;

abstract class BaseWebApp extends BaseApp
{

    public function appName(): string
    {
        return 'web';
    }

    public function subscribes(): array
    {
        return [
            WebDetectTestEnvSubscriber::class,
        ];
    }

    public function import(): array
    {
        return ['i18next', 'container', 'rbac', 'symfonyWeb'];
    }

    protected function configDispatcher(EventDispatcherConfiguratorInterface $configurator): void
    {
        $configurator->addSubscriber(FindRouteSubscriber::class);
        $configurator->addSubscriber(WebFirewallSubscriber::class);
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
        $containerConfigurator->singleton(HttpKernelInterface::class, HttpKernel::class);
        $containerConfigurator->bind(ErrorRendererInterface::class, HtmlErrorRenderer::class);
        $containerConfigurator->singleton(View::class, View::class);
    }
}
