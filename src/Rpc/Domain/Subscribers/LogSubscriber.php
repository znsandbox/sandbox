<?php

namespace ZnLib\Rpc\Domain\Subscribers;

use ZnLib\Rpc\Domain\Enums\RpcEventEnum;
use ZnLib\Rpc\Domain\Events\RpcResponseEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Traits\EntityManagerTrait;

class LogSubscriber extends \ZnLib\Rpc\Domain\Subscribers\LogSubscriber //implements EventSubscriberInterface
{

    /*use EntityManagerTrait;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            RpcEventEnum::AFTER_RUN_ACTION => 'onAfterRunAction',
        ];
    }

    public function onAfterRunAction(RpcResponseEvent $event)
    {
        $context = [
            'request' => EntityHelper::toArray($event->getRequestEntity()),
            'response' => EntityHelper::toArray($event->getResponseEntity()),
        ];
        if ($event->getResponseEntity()->isError()) {
            $this->logger->error('request_error', $context);
        } else {
            $this->logger->info('request_success', $context);
        }
    }*/
}
