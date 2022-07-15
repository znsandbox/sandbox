<?php

namespace ZnSandbox\Sandbox\Person\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnLib\Components\Status\Enums\StatusEnum;
use ZnDomain\Сomponents\EnumRepository\Constraints\Enum;
use ZnDomain\Validator\Interfaces\ValidationByMetadataInterface;
use ZnDomain\Entity\Interfaces\UniqueInterface;
use ZnDomain\Entity\Interfaces\EntityIdInterface;

class InheritanceEntity implements ValidationByMetadataInterface, UniqueInterface, EntityIdInterface
{

    private $id = null;

    private $personId = null;

    private $parentPersonId = null;

    private $statusId = StatusEnum::ENABLED;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('personId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('parentPersonId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Enum([
            'class' => StatusEnum::class,
        ]));
    }

    public function unique() : array
    {
        return [];
    }

    public function setId($value) : void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPersonId($value) : void
    {
        $this->personId = $value;
    }

    public function getPersonId()
    {
        return $this->personId;
    }

    public function setParentPersonId($value) : void
    {
        $this->parentPersonId = $value;
    }

    public function getParentPersonId()
    {
        return $this->parentPersonId;
    }

    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }


}

