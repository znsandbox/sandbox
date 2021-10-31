<?php

namespace ZnSandbox\Sandbox\App\Libs;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\App\Libs\ConfigManager;
use ZnCore\Base\Libs\App\Loaders\BundleLoader;
use ZnCore\Base\Libs\App\Loaders\ConfigCollectionLoader;
use ZnCore\Base\Libs\App\Subscribers\ConfigureContainerSubscriber;
use ZnCore\Base\Libs\App\Subscribers\ConfigureEntityManagerSubscriber;
use ZnCore\Base\Libs\Container\ContainerAwareTrait;
use ZnLib\Rpc\Symfony4\HttpKernel\RpcFramework;

class ZnCore
{

    use ContainerAwareTrait;

    public function init(): void {
        $containerConfigurator = ContainerHelper::getContainerConfiguratorByContainer($this->getContainer());
        $this->configContainer($containerConfigurator);
    }

    public function loadBundles(array $bundles, array $import, string $appName):void {
        $bundleLoader = new BundleLoader($bundles, $import);
        /** @var ConfigCollectionLoader $configCollectionLoader */
        $configCollectionLoader = $this->getContainer()->get(ConfigCollectionLoader::class);
        $configCollectionLoader->addSubscriber(ConfigureContainerSubscriber::class);
        $configCollectionLoader->addSubscriber(ConfigureEntityManagerSubscriber::class);
        $configCollectionLoader->setLoader($bundleLoader);
        $config = $configCollectionLoader->loadMainConfig($appName);
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
//        $containerConfigurator->singleton(EventDispatcherInterface::class, EventDispatcher::class);
        $containerConfigurator->singleton(ContainerInterface::class, function () {
            return $this->getContainer();
        });
        $containerConfigurator->singleton(EventDispatcherInterface::class, function () {
            return new EventDispatcher();
        });

        $containerConfigurator->singleton(ConfigManagerInterface::class, ConfigManager::class);
        $containerConfigurator->singleton(ZnCore::class, function () {
            return $this;
        });
        $containerConfigurator->singleton(ContainerConfiguratorInterface::class, function () use($containerConfigurator) {
            return $containerConfigurator;
        });
    }
}
