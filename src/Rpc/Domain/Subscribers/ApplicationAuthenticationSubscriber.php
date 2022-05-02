<?php

namespace ZnLib\Rpc\Domain\Subscribers;

use ZnLib\Rpc\Domain\Enums\RpcEventEnum;
use ZnLib\Rpc\Domain\Events\RpcRequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnBundle\User\Domain\Exceptions\UnauthorizedException;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Traits\EntityManagerTrait;
use ZnLib\Rpc\Domain\Entities\RpcRequestEntity;

class ApplicationAuthenticationSubscriber extends \ZnLib\Rpc\Domain\Subscribers\ApplicationAuthenticationSubscriber  //implements EventSubscriberInterface
{

//    use EntityManagerTrait;
//
//    public static function getSubscribedEvents()
//    {
//        return [
//            RpcEventEnum::BEFORE_RUN_ACTION => 'onBeforeRunAction',
//        ];
//    }
//
//    public function onBeforeRunAction(RpcRequestEvent $event)
//    {
//        $requestEntity = $event->getRequestEntity();
//        $methodEntity = $event->getMethodEntity();
//        $this->applicationAuthentication($requestEntity);
//    }
//
//    /**
//     * Аутентификация приложения
//     * @param RpcRequestEntity $requestEntity
//     * @throws UnauthorizedException
//     */
//    private function applicationAuthentication(RpcRequestEntity $requestEntity)
//    {
//        $apiKey = $requestEntity->getMetaItem('ApiKey');
//        if ($apiKey) {
//            try {
//                // todo: реализовать
//            } catch (NotFoundException $e) {
//                throw new UnauthorizedException('Bad ApiKey or Signature');
//            }
//        }
//    }
}
