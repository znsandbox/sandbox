<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Services;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\NotifyEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TransportEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Libs\ContactDriverInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\NotifyServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\SettingServiceInterface;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Services\TypeServiceInterface;
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
    private $typeService;

    public function __construct(
        EntityManagerInterface $em,
        SettingServiceInterface $settingService,
        TypeServiceInterface $typeService
    )
    {
        $this->setEntityManager($em);
        $this->settingService = $settingService;
        $this->typeService = $typeService;
    }

    public function getEntityClass(): string
    {
        return NotifyEntity::class;
    }

    public function send2(NotifyEntity $notifyEntity)
    {
        ValidationHelper::validateEntity($notifyEntity);
        $typeEntity = $this->typeService->oneByIdWithI18n($notifyEntity->getTypeId());
        $notifyEntity->setType($typeEntity);
        $this->prepareAttributes($notifyEntity);
        $this->sendToDrivers2($notifyEntity);
    }

    public function send(NotifyEntity $notifyEntity)
    {
        ValidationHelper::validateEntity($notifyEntity);
        $typeEntity = $this->typeService->oneByIdWithI18n($notifyEntity->getTypeId());
        $notifyEntity->setType($typeEntity);
        $this->prepareAttributes($notifyEntity);
        $this->sendToDrivers($notifyEntity);
    }

//    public function oneTypeByIdWithI18n(int $id): TypeEntity
//    {
//        $query = new Query();
//        $query->with(['i18n']);
//        /** @var TypeEntity $typeEntity */
//        $typeEntity = $this->getEntityManager()->oneById(TypeEntity::class, $id, $query);
//        return $typeEntity;
//    }

    public function sendNotifyByTypeName(string $typeName, int $userId, array $attributes = [])
    {
        $typeEntity = $this->typeService->oneByName($typeName);
        $notifyEntity = new NotifyEntity();
        $notifyEntity->setRecipientId($userId);
        $notifyEntity->setTypeId($typeEntity->getId());
        $notifyEntity->setAttributes($attributes);
        $this->send2($notifyEntity);
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

    private function sendToDrivers2(NotifyEntity $notifyEntity)
    {

        //dd($notifyEntity);

        $types = [
            'email',
        ];
        //dd($notifyEntity);
        //$recipientSettings = $this->settingService->allByUserAndType($notifyEntity->getRecipientId(), $notifyEntity->getTypeId());
        foreach ($notifyEntity->getType()->getTransports() as $transportEntity) {
            /** @var TransportEntity $transportEntity */
            //if ($settingEntity->getIsEnabled()) {
                //$name = $settingEntity->getContactType()->getName();
                $this->sendMessage2($transportEntity->getHandlerClass(), $notifyEntity);
            //}
        }
    }

    private function sendMessage2(string $driverClass, NotifyEntity $notifyEntity)
    {
        /** @var ContactDriverInterface $driverInstance */
        $driverInstance = ClassHelper::createObject($driverClass);
        $driverInstance->send($notifyEntity);
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
