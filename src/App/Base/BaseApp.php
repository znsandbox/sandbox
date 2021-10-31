<?php

namespace ZnSandbox\Sandbox\App\Base;

use Psr\Container\ContainerInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Libs\App\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\Container\ContainerAttributeTrait;
use ZnCore\Base\Libs\DotEnv\DotEnv;
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
    }

    public function init(): void
    {
        $this->initEnv();
        $this->configContainer($this->containerConfigurator);
        $this->znCore->loadBundles($this->bundles(), $this->import(), $this->appName());
        $this->configDispatcher($this->getEventDispatcher());
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
