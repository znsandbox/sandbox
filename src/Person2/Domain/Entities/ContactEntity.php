<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class ContactEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{

    private $id = null;

    private $personId = null;

    private $attributeId = null;

    private $value = null;

    private $statusId = null;

    private $sort = null;

    private $createdAt = null;

    private $updatedAt = null;

    private $attribute = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('personId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('attributeId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('value', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('sort', new Assert\NotBlank);
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank);
        $metadata->addPropertyConstraint('updatedAt', new Assert\NotBlank);
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

    public function setAttributeId($value) : void
    {
        $this->attributeId = $value;
    }

    public function getAttributeId()
    {
        return $this->attributeId;
    }

    public function setValue($value) : void
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function setSort($value) : void
    {
        $this->sort = $value;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setCreatedAt($value) : void
    {
        $this->createdAt = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($value) : void
    {
        $this->updatedAt = $value;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function setAttribute($attribute): void
    {
        $this->attribute = $attribute;
    }

}
