<?php

namespace ZnSandbox\Sandbox\App\Apps;

use Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnLib\Web\Symfony4\Subscribers\ErrorHandleSubscriber;
use ZnLib\Web\Symfony4\Subscribers\FindRouteSubscriber;
use ZnLib\Web\Symfony4\Subscribers\WebDetectTestEnvSubscriber;
use ZnLib\Web\Symfony4\Subscribers\WebFirewallSubscriber;
use ZnLib\Web\View\View;
use ZnSandbox\Sandbox\App\Base\BaseApp;

abstract class WebApp extends BaseApp
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
        return ['i18next', 'container', 'symfonyWeb'];
    }

    protected function configDispatcher(EventDispatcherInterface $dispatcher): void
    {
        $dispatcher->addSubscriber($this->container->get(FindRouteSubscriber::class));
        $dispatcher->addSubscriber($this->container->get(WebFirewallSubscriber::class));
        //$dispatcher->addSubscriber($this->container->get(UnauthorizedSubscriber::class));
        $dispatcher->addSubscriber($this->container->get(ErrorHandleSubscriber::class));
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
        $containerConfigurator->singleton(HttpKernelInterface::class, HttpKernel::class);
        $containerConfigurator->bind(ErrorRendererInterface::class, HtmlErrorRenderer::class);
        $containerConfigurator->singleton(View::class, View::class);
    }
}
