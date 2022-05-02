<?php

namespace ZnLib\Rpc\Domain\Subscribers;

class CryptoProviderSubscriber extends \ZnLib\Rpc\Domain\Subscribers\CryptoProviderSubscriber //implements EventSubscriberInterface
{

    /*use EntityManagerTrait;

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
        //$this->cryptoProvider->verifyRequest($event->getRequestEntity());
    }

    public function onAfterRunAction(RpcResponseEvent $event)
    {
        $settingsEntity = $this->settingsService->view();
        if($settingsEntity->getCryptoProviderStrategy() == RpcCryptoProviderStrategyEnum::JSON_DSIG) {
            $this->cryptoProvider->signResponse($event->getResponseEntity());
        }
    }*/
}
