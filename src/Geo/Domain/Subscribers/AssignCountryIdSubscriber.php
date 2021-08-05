<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Subscribers;

use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Services\CountryServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Domain\Enums\EventEnum;
use ZnCore\Domain\Events\EntityEvent;
use ZnCore\Domain\Events\QueryEvent;

class AssignCountryIdSubscriber implements EventSubscriberInterface
{

    private $countryService;

    public function __construct(CountryServiceInterface $countryService)
    {
        $this->countryService = $countryService;
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEnum::BEFORE_CREATE_ENTITY => 'onBeforeCreate',
            EventEnum::BEFORE_FORGE_QUERY => 'onForgeQuery',
        ];
    }

    public function onForgeQuery(QueryEvent $event)
    {
        $event->getQuery()->where('country_id', $this->countryService->getCurrentCountry()->getId());
    }

    public function onBeforeCreate(EntityEvent $event)
    {
        EnvHelper::showErrors();
        $entity = $event->getEntity();
        $countryEntity = $this->countryService->getCurrentCountry();
        $entity->setCountryId($countryEntity->getId());
    }
}
