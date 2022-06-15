<?php

namespace ZnSandbox\Sandbox\App\Libs;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\App\Libs\ConfigManager;
use ZnCore\Base\Libs\App\Loaders\BundleLoader;
use ZnCore\Base\Libs\App\Loaders\ConfigCollectionLoader;
use ZnCore\Base\Libs\Container\Libs\ContainerConfigurator;
use ZnCore\Base\Libs\Event\Interfaces\EventDispatcherConfiguratorInterface;
use ZnCore\Base\Libs\Event\Libs\EventDispatcherConfigurator;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\EntityManager;
use ZnSandbox\Sandbox\App\Subscribers\ConfigureContainerSubscriber;
use ZnCore\Base\Libs\App\Subscribers\ConfigureEntityManagerSubscriber;
use ZnCore\Base\Libs\Container\Traits\ContainerAwareTrait;

class ZnCore
{

    use ContainerAwareTrait;
    
    public function init(): void
    {
        $container = $this->getContainer();
        ContainerHelper::setContainer($container);

//        $containerConfigurator = $this->getContainerConfigurator();
        $containerConfigurator = new ContainerConfigurator($container);
        $this->configContainer($containerConfigurator);

//        $this->addContainerConfig([$this, 'configContainer']);
    }

    public function addContainerConfig(callable $function) {
        $container = $this->getContainer();
        $containerConfigurator = new ContainerConfigurator($container);
//        $containerConfigurator = $this->getContainerConfigurator();
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
        return new ContainerConfigurator($container);
//        return ContainerHelper::getContainerConfiguratorByContainer($this->getContainer());
    }

    protected function configContainer(ContainerConfiguratorInterface $containerConfigurator): void
    {
        $containerConfigurator->singleton(ContainerInterface::class, function () {
            return $this->getContainer();
        });
        $containerConfigurator->singleton(ContainerConfiguratorInterface::class, function () use ($containerConfigurator) {
            return $containerConfigurator;
        });
//        $containerConfigurator->singleton(EntityManagerInterface::class, EntityManager::class);
        $containerConfigurator->singleton(EntityManagerInterface::class, function (ContainerInterface $container) {
            $em = EntityManager::getInstance($container);
//            $eloquentOrm = $container->get(EloquentOrm::class);
//            $em->addOrm($eloquentOrm);
            return $em;
        });


        $containerConfigurator->singleton(EventDispatcherConfiguratorInterface::class, EventDispatcherConfigurator::class);
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
