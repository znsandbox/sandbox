<?php

namespace ZnSandbox\Sandbox\App\Apps;

use ZnSandbox\Sandbox\App\Base\BaseApp;
use Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnLib\Web\Symfony4\Subscribers\ErrorHandleSubscriber;
use ZnLib\Web\Symfony4\Subscribers\FindRouteSubscriber;
use ZnLib\Web\Symfony4\Subscribers\SetLayoutSubscriber;
use ZnLib\Web\Symfony4\Subscribers\WebDetectTestEnvSubscriber;
use ZnLib\Web\Symfony4\Subscribers\WebFirewallSubscriber;
use ZnLib\Web\View\View;

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

    /*protected function bundles(): array
    {
        $bundles = include __DIR__ . '/../../../config/bundle.php';
        $bundles[] = new \App\AppWeb\Bundle(['all']);
        return $bundles;
    }*/

    protected function configDispatcher(EventDispatcherInterface $dispatcher): void
    {
        $dispatcher->addSubscriber($this->container->get(FindRouteSubscriber::class));
        $dispatcher->addSubscriber($this->container->get(WebFirewallSubscriber::class));
        //$dispatcher->addSubscriber($this->container->get(UnauthorizedSubscriber::class));
        $dispatcher->addSubscriber($this->container->get(ErrorHandleSubscriber::class));
        /*$setLayoutSubscriber = $this->container->get(SetLayoutSubscriber::class);
        $setLayoutSubscriber->setLayout(__DIR__ . '/../../../src/Common/views/layouts/website/main.php');
        $dispatcher->addSubscriber($setLayoutSubscriber);*/
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
        $containerConfigurator->singleton(HttpKernelInterface::class, HttpKernel::class);
        $containerConfigurator->bind(ErrorRendererInterface::class, HtmlErrorRenderer::class);
        $containerConfigurator->singleton(View::class, View::class);
    }
}
