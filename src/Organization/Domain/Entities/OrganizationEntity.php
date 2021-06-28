<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class OrganizationEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{

    private $id = null;

    private $title = null;

    private $typeId = null;
    
    private $description = null;

    private $cityId = null;

    private $bin = null;

    private $statusId = StatusEnum::ENABLED;

    private $type = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        //$metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('title', new Assert\NotBlank);
        $metadata->addPropertyConstraint('typeId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank);
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

    public function setTitle($value) : void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTypeId($value) : void
    {
        $this->typeId = $value;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($cityId): void
    {
        $this->cityId = $cityId;
    }

    public function getBin()
    {
        return $this->bin;
    }

    public function setBin($bin): void
    {
        $this->bin = $bin;
    }


    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function getType(): ?TypeEntity
    {
        return $this->type;
    }

    public function setType(TypeEntity $type): void
    {
        $this->type = $type;
    }
}
