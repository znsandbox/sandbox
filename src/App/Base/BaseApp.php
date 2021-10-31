<?php

namespace ZnSandbox\Sandbox\App\Base;

use ZnSandbox\Sandbox\App\Interfaces\AppInterface;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\Container\ContainerAttributeTrait;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Base\Libs\Event\Traits\EventDispatcherTrait;
use ZnLib\Web\Symfony4\Enums\AppEventEnum;
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
        ZnCore $znCore,
//        EventDispatcherInterface $dispatcher,
        ContainerConfiguratorInterface $containerConfigurator
    )
    {
        $this->setContainer($container);
        $this->containerConfigurator = $containerConfigurator;
        $this->znCore = $znCore;
    }

    public function init(): void
    {
        $this->initEnv();
        $this->configContainer($this->containerConfigurator);
        $this->loadConfig();
        $this->configEventDispatcher();
    }

    protected function configEventDispatcher(): void
    {
        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = $this->getContainer()->get(EventDispatcherInterface::class);
        $this->configDispatcher($dispatcher);
        $this->setEventDispatcher($dispatcher);
    }

    protected function loadConfig(): void
    {
        $bundles = $this->bundles();
        $import = $this->import();
        $appName = $this->appName();

        $this->znCore->loadBundles($bundles, $import, $appName);

    }

    protected function initEnv(): void
    {
        $event = new Event();
        $this->getEventDispatcher()->dispatch($event, AppEventEnum::BEFORE_INIT_ENV);
//        EnvHelper::prepareTestEnv();
        DotEnv::init();
        EnvHelper::setErrorVisibleFromEnv();
        $this->getEventDispatcher()->dispatch($event, AppEventEnum::AFTER_INIT_ENV);
    }
}
