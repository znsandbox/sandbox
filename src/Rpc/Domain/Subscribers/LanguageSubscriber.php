<?php

namespace ZnSandbox\Sandbox\Rpc\Domain\Subscribers;

class LanguageSubscriber extends \ZnLib\Rpc\Domain\Subscribers\LanguageSubscriber //implements EventSubscriberInterface
{

    /*use EntityManagerTrait;

    private $languageService;

    public function __construct(RuntimeLanguageServiceInterface $languageService)
    {
        $this->languageService = $languageService;
    }

    public static function getSubscribedEvents()
    {
        return [
            RpcEventEnum::BEFORE_RUN_ACTION => 'onBeforeRunAction'
        ];
    }

    public function onBeforeRunAction(RpcRequestEvent $event)
    {
        $languageCode = $event->getRequestEntity()->getMetaItem(HttpHeaderEnum::LANGUAGE);
        if(!empty($languageCode)) {
            $this->languageService->setLanguage($languageCode);
        }
    }*/
}
