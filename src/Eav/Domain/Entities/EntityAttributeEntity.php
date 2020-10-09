<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class EntityAttributeEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;

    private $entityId = null;

    private $attributeId = null;

    private $default = null;

    private $isRequired = null;

    private $name = null;

    private $title = null;

    private $description = null;

    private $sort = null;

    private $status = null;

    private $attribute;

    public function validationRules()
    {
        return [
            'id' => [
                new Assert\NotBlank,
            ],
            'entityId' => [
                new Assert\NotBlank,
            ],
            'attributeId' => [
                new Assert\NotBlank,
            ],
            'name' => [
                new Assert\NotBlank,
            ],
            'title' => [
                new Assert\NotBlank,
            ],
            'description' => [
                new Assert\NotBlank,
            ],
            'sort' => [
                new Assert\NotBlank,
            ],
            'status' => [
                new Assert\NotBlank,
            ],
        ];
    }

    public function setId($value) : void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEntityId($value) : void
    {
        $this->entityId = $value;
    }

    public function getEntityId()
    {
        return $this->entityId;
    }

    public function setattributeId($value) : void
    {
        $this->attributeId = $value;
    }

    public function getattributeId()
    {
        return $this->attributeId;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default): void
    {
        $this->default = $default;
    }

    public function getIsRequired()
    {
        return $this->isRequired;
    }

    public function setIsRequired($isRequired): void
    {
        $this->isRequired = $isRequired;
    }

    public function setName($value) : void
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTitle($value) : void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($value) : void
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setSort($value) : void
    {
        $this->sort = $value;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setStatus($value) : void
    {
        $this->status = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getAttribute(): ?AttributeEntity
    {
        return $this->attribute;
    }

    public function setAttribute(AttributeEntity $attribute): void
    {
        $this->attribute = $attribute;
    }

}
