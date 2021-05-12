<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs\ContactDriverInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\NotifyServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\SettingServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Libs\ContactDrivers\EmailDriver;
use ZnSandbox\Sandbox\UserNotify\Domain\Libs\ContactDrivers\PhoneDriver;
use ZnSandbox\Sandbox\UserNotify\Domain\Libs\ContactDrivers\WebDriver;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Domain\Helpers\ValidationHelper;
use ZnCore\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Traits\EntityManagerTrait;

class NotifyService implements NotifyServiceInterface, GetEntityClassInterface
{

    use EntityManagerTrait;

    private $settingService;
    private $em;

    public function __construct(
        EntityManagerInterface $em,
        SettingServiceInterface $settingService
    )
    {
        $this->setEntityManager($em);
        $this->settingService = $settingService;
    }

    public function getEntityClass(): string
    {
        return NotifyEntity::class;
    }

    public function send(NotifyEntity $notifyEntity)
    {
        ValidationHelper::validateEntity($notifyEntity);
        $typeEntity = $this->oneTypeByIdWithI18n($notifyEntity->getTypeId());
        $notifyEntity->setType($typeEntity);
        $this->prepareAttributes($notifyEntity);
        $this->sendToDrivers($notifyEntity);
    }

    private function oneTypeByIdWithI18n(int $id): TypeEntity
    {
        $query = new Query();
        $query->with(['i18n']);
        /** @var TypeEntity $typeEntity */
        $typeEntity = $this->getEntityManager()->oneById(TypeEntity::class, $id, $query);
        return $typeEntity;
    }

    public function sendNotify(int $typeId, int $userId, array $attributes = [])
    {
        $notifyEntity = new NotifyEntity();
        $notifyEntity->setRecipientId($userId);
        $notifyEntity->setTypeId($typeId);
        $notifyEntity->setAttributes($attributes);
        $this->send($notifyEntity);
    }

    private function sendToDrivers(NotifyEntity $notifyEntity)
    {
        $recipientSettings = $this->settingService->allByUserAndType($notifyEntity->getRecipientId(), $notifyEntity->getTypeId());
        foreach ($recipientSettings as $settingEntity) {
            if ($settingEntity->getIsEnabled()) {
                $name = $settingEntity->getContactType()->getName();
                $this->sendMessage($name, $notifyEntity);
            }
        }
    }

    private function sendMessage(string $name, NotifyEntity $notifyEntity)
    {
        $driverAssoc = [
            'web' => WebDriver::class,
            'phone' => PhoneDriver::class,
            'email' => EmailDriver::class,
        ];
        $driverClass = $driverAssoc[$name];
        /** @var ContactDriverInterface $driverInstance */
        $driverInstance = ClassHelper::createObject($driverClass);
        $driverInstance->send($notifyEntity);
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
