<?php

namespace ZnSandbox\Sandbox\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;

class ConfigureContainerSubscriber implements EventSubscriberInterface
{

//    use EntityManagerTrait;

    private $containerConfigurator;

    public function __construct(ContainerConfiguratorInterface $containerConfigurator)
    {
        $this->containerConfigurator = $containerConfigurator;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEventEnum::AFTER_LOAD_CONFIG => 'onAfterLoadConfig',
        ];
    }

    public function onAfterLoadConfig(LoadConfigEvent $event)
    {
        $config = $event->getConfig();
//        $container = $event->getKernel()->getContainer();
        if (!empty($config['container'])) {
            ContainerHelper::configContainerFromArray($this->containerConfigurator, $config['container']);
        }
//        $event->setConfig($config);
    }
}
