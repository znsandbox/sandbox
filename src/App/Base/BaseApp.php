<?php

namespace ZnSandbox\Sandbox\App\Base;

use Psr\Container\ContainerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Libs\App\Helpers\EnvHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\Container\Traits\ContainerAttributeTrait;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Base\Libs\Event\Interfaces\EventDispatcherConfiguratorInterface;
use ZnCore\Base\Libs\Event\Traits\EventDispatcherTrait;
use ZnSandbox\Sandbox\App\Enums\AppEventEnum;
use ZnSandbox\Sandbox\App\Interfaces\AppInterface;
use ZnSandbox\Sandbox\App\Libs\ZnCore;

abstract class BaseApp implements AppInterface
{

    use ContainerAttributeTrait;
    use EventDispatcherTrait;

    private $containerConfigurator;
    private $znCore;

    abstract public function appName(): string;

    abstract public function import(): array;

    abstract protected function bundles(): array;

    public function __construct(
        ContainerInterface $container,
        EventDispatcherInterface $dispatcher,
        ZnCore $znCore,
        ContainerConfiguratorInterface $containerConfigurator
    )
    {
        $this->setContainer($container);
        $this->setEventDispatcher($dispatcher);
        $this->containerConfigurator = $containerConfigurator;
        $this->znCore = $znCore;
//        defined('REQUEST_ID') OR define('REQUEST_ID', Uuid::v4()->toRfc4122());
    }

    public function init(): void
    {
        $this->dispatchEvent(AppEventEnum::BEFORE_INIT_ENV);
        $this->initEnv();
        $this->dispatchEvent(AppEventEnum::AFTER_INIT_ENV);

        $this->dispatchEvent(AppEventEnum::BEFORE_INIT_CONTAINER);
        $this->initContainer();
        $this->dispatchEvent(AppEventEnum::AFTER_INIT_CONTAINER);

        $this->dispatchEvent(AppEventEnum::BEFORE_INIT_BUNDLES);
        $this->initBundles();
        $this->dispatchEvent(AppEventEnum::AFTER_INIT_BUNDLES);

        $this->dispatchEvent(AppEventEnum::BEFORE_INIT_DISPATCHER);
        $this->initDispatcher();
        $this->dispatchEvent(AppEventEnum::AFTER_INIT_DISPATCHER);
    }

    protected function initEnv(): void
    {
//        EnvHelper::prepareTestEnv();
        DotEnv::init();
        EnvHelper::setErrorVisibleFromEnv();
    }

    protected function initContainer(): void
    {
        $this->configContainer($this->containerConfigurator);
    }

    protected function initBundles(): void
    {
        $this->znCore->loadBundles($this->bundles(), $this->import(), $this->appName());
    }

    protected function initDispatcher(): void
    {
        $this->configDispatcher($this->getEventDispatcher());

        $eventDispatcherConfigurator = $this->getContainer()->get(EventDispatcherConfiguratorInterface::class);
        $this->configDispatcher2($eventDispatcherConfigurator);
    }

    protected function configDispatcher2(EventDispatcherConfiguratorInterface $configurator): void {

    }

    /**
     * @param EventDispatcherInterface $dispatcher
     * @todo: переидти на метод configDispatcher2
     * @deprecated
     * @see configDispatcher2
     */
    protected function configDispatcher(EventDispatcherInterface $dispatcher): void {

    }

    protected function dispatchEvent(string $eventName): void {
        $event = new Event();
        $this->getEventDispatcher()->dispatch($event, $eventName);
    }
}
