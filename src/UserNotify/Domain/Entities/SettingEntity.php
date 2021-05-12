<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Entities;

use ZnBundle\Person\Domain\Entities\ContactTypeEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class SettingEntity implements ValidateEntityByMetadataInterface, EntityIdInterface
{

    private $id = null;

    private $userId = null;

    private $notifyTypeId = null;

    private $contactTypeId = null;

    private $isEnabled = false;

    private $notifyType;

    private $contactType;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('userId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('notifyTypeId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('contactTypeId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('isEnabled', new Assert\Choice([
            'choices' => [true, false]
        ]));
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUserId($value): void
    {
        $this->userId = $value;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setNotifyTypeId(int $value): void
    {
        $this->notifyTypeId = $value;
    }

    public function getNotifyTypeId(): int
    {
        return $this->notifyTypeId;
    }

    public function setContactTypeId(int $value): void
    {
        $this->contactTypeId = $value;
    }

    public function getContactTypeId(): int
    {
        return $this->contactTypeId;
    }

    public function setIsEnabled(bool $value): void
    {
        $this->isEnabled = $value;
    }

    public function getIsEnabled(): bool
    {
        return $this->isEnabled;
    }

    public function getNotifyType(): ?TypeEntity
    {
        return $this->notifyType;
    }

    public function setNotifyType(TypeEntity $notifyType): void
    {
        $this->notifyType = $notifyType;
    }

    public function getContactType(): ?ContactTypeEntity
    {
        return $this->contactType;
    }

    public function setContactType(ContactTypeEntity $contactType): void
    {
        $this->contactType = $contactType;
    }

}
