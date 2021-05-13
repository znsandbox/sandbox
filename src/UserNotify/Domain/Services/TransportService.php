<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use ZnCore\Base\Exceptions\NotInstanceOfException;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TransportEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs\ContactDriverInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TransportRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TransportServiceInterface;

/**
 * @method TransportRepositoryInterface getRepository()
 */
class TransportService extends BaseCrudService implements TransportServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return TransportEntity::class;
    }

    public function send(NotifyEntity $notifyEntity)
    {



        $transportCollection = $this->getRepository()->allEnabledByTypeId($notifyEntity->getTypeId());
        foreach ($transportCollection as $transportEntity) {
            $driverInstance = ClassHelper::createObject($transportEntity->getHandlerClass(), [], ContactDriverInterface::class);
            if ($driverInstance instanceof ContactDriverInterface) {
                $driverInstance->send($notifyEntity);
            } else {
                throw new NotInstanceOfException("Class \"{$transportEntity->getHandlerClass()}\" not instanceof \"ContactDriverInterface\"");
            }
        }
    }
}
