<?php

namespace ZnSandbox\Sandbox\App\Libs;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\App\Libs\ConfigManager;
use ZnCore\Base\Libs\App\Loaders\BundleLoader;
use ZnCore\Base\Libs\App\Loaders\ConfigCollectionLoader;
use ZnSandbox\Sandbox\App\Subscribers\ConfigureContainerSubscriber;
use ZnCore\Base\Libs\App\Subscribers\ConfigureEntityManagerSubscriber;
use ZnCore\Base\Libs\Container\ContainerAwareTrait;

class ZnCore
{

    use ContainerAwareTrait;
    
    public function init(): void
    {
        ContainerHelper::setContainer($this->getContainer());
        $this->addContainerConfig([$this, 'configContainer']);
        
//        $containerConfigurator = $this->getContainerConfigurator();
//        $this->configContainer($containerConfigurator);
    }

    public function addContainerConfig(callable $function) {
        $containerConfigurator = $this->getContainerConfigurator();
        call_user_func($function, $containerConfigurator);
        //$function($containerConfigurator);
    }
    
    public function loadBundles(array $bundles, array $import, string $appName): void
    {
        $bundleLoader = new BundleLoader($bundles, $import);
        /** @var ConfigCollectionLoader $configCollectionLoader */
        $configCollectionLoader = $this->getContainer()->get(ConfigCollectionLoader::class);
        $configCollectionLoader->addSubscriber(ConfigureContainerSubscriber::class);
        $configCollectionLoader->addSubscriber(ConfigureEntityManagerSubscriber::class);
        $configCollectionLoader->setLoader($bundleLoader);
        $config = $configCollectionLoader->loadMainConfig($appName);
    }

    protected function getContainerConfigurator() {
        return ContainerHelper::getContainerConfiguratorByContainer($this->getContainer());
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
        $containerConfigurator->singleton(ContainerInterface::class, function () {
            return $this->getContainer();
        });
        $containerConfigurator->singleton(ContainerConfiguratorInterface::class, function () use ($containerConfigurator) {
            return $containerConfigurator;
        });
        $containerConfigurator->singleton(EventDispatcherInterface::class, EventDispatcher::class);
        $containerConfigurator->singleton(\Psr\EventDispatcher\EventDispatcherInterface::class, EventDispatcherInterface::class);
        $containerConfigurator->singleton(ConfigManagerInterface::class, ConfigManager::class);
        $containerConfigurator->singleton(ZnCore::class, function () {
            return $this;
        });
//        $containerConfigurator->singleton(\ZnLib\Web\View\Resources\Css::class, \ZnLib\Web\View\Resources\Css::class);
//        $containerConfigurator->singleton(\ZnLib\Web\View\Resources\Js::class, \ZnLib\Web\View\Resources\Js::class);
//        $containerConfigurator->singleton(\ZnLib\Web\View\View::class, \ZnLib\Web\View\View::class);
    }
}
