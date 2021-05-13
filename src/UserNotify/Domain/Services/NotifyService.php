<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use ZnCore\Domain\Helpers\ValidationHelper;
use ZnCore\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\NotifyServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TransportServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TypeServiceInterface;

class NotifyService implements NotifyServiceInterface, GetEntityClassInterface
{

    use EntityManagerTrait;

    private $em;
    private $typeService;
    private $transportService;

    public function __construct(
        EntityManagerInterface $em,
        TypeServiceInterface $typeService,
        TransportServiceInterface $transportService
    )
    {
        $this->setEntityManager($em);
        $this->typeService = $typeService;
        $this->transportService = $transportService;
    }

    public function getEntityClass(): string
    {
        return NotifyEntity::class;
    }

    public function sendNotifyByTypeName(string $typeName, int $userId, array $attributes = [])
    {
        $typeEntity = $this->typeService->oneByName($typeName);
        $notifyEntity = $this->getEntityManager()->createEntity(NotifyEntity::class);
//        $notifyEntity = new NotifyEntity();
        $notifyEntity->setType($typeEntity);
        $notifyEntity->setRecipientId($userId);
        $notifyEntity->setTypeId($typeEntity->getId());
        $notifyEntity->setAttributes($attributes);
        $this->sendNotify($notifyEntity);
    }

    private function sendNotify(NotifyEntity $notifyEntity)
    {
        ValidationHelper::validateEntity($notifyEntity);
//        $typeEntity = $this->typeService->oneByIdWithI18n($notifyEntity->getTypeId());
//        $notifyEntity->setType($typeEntity);
        $this->prepareAttributes($notifyEntity);
        $this->transportService->send($notifyEntity);
    }

    private function prepareAttributes(NotifyEntity $notifyEntity)
    {
        foreach (['api_url', 'web_url', 'admin_url', 'storage_url', 'static_url'] as $name) {
            $upperName = strtoupper($name);
            if (isset($_ENV[$upperName])) {
                $lowerName = strtolower($name);
                $notifyEntity->addAttribute('env.' . $lowerName, rtrim($_ENV[$upperName], '/'));
            }
        }
    }
}
