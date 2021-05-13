<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use Illuminate\Support\Collection;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeTransportEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs\ContactDriverInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TransportRepositoryInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TransportServiceInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TransportEntity;

/**
 * @method TransportRepositoryInterface getRepository()
 */
class TransportService extends BaseCrudService implements TransportServiceInterface
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return TransportEntity::class;
    }

    public function send(NotifyEntity $notifyEntity)
    {
        $transportCollection = $this->getRepository()->allByTypeId($notifyEntity->getTypeId());
        foreach ($transportCollection as $transportEntity) {
            /** @var TransportEntity $transportEntity */
            /** @var ContactDriverInterface $driverInstance */
            $driverInstance = ClassHelper::createObject($transportEntity->getHandlerClass());
            $driverInstance->send($notifyEntity);
        }
    }
}
