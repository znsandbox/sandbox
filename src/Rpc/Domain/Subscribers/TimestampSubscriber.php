<?php

namespace ZnSandbox\Sandbox\Rpc\Domain\Subscribers;

class TimestampSubscriber extends \ZnLib\Rpc\Domain\Subscribers\TimestampSubscriber //implements EventSubscriberInterface
{

    /* use EntityManagerTrait;

     private $cryptoProvider;
     private $settingsService;

     public function __construct(CryptoProviderInterface $cryptoProvider, SettingsServiceInterface $settingsService)
     {
         $this->cryptoProvider = $cryptoProvider;
         $this->settingsService = $settingsService;
     }

     public static function getSubscribedEvents()
     {
         return [
             RpcEventEnum::BEFORE_RUN_ACTION => 'onBeforeRunAction',
             RpcEventEnum::AFTER_RUN_ACTION => 'onAfterRunAction',
         ];
     }

     public function onBeforeRunAction(RpcRequestEvent $event)
     {
         $settingsEntity = $this->settingsService->view();
         if($settingsEntity->getRequireTimestamp()) {
             $timestamp = $event->getRequestEntity()->getMetaItem(HttpHeaderEnum::TIMESTAMP);
             if (empty($timestamp)) {
                 throw new InvalidRequestException('Empty timestamp');
             }
         }
     }

     public function onAfterRunAction(RpcResponseEvent $event)
     {
         $settingsEntity = $this->settingsService->view();
         if($settingsEntity->getRequireTimestamp()) {
             $event->getResponseEntity()->addMeta(HttpHeaderEnum::TIMESTAMP, date(\DateTime::ISO8601));
         }
     }*/
}
