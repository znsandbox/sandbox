<?php

namespace ZnUser\Rbac\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class InheritanceEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{

    private $id = null;

    private $parentName = null;

    private $childName = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('parentName', new Assert\NotBlank);
        $metadata->addPropertyConstraint('childName', new Assert\NotBlank);
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

    public function setParentName($value) : void
    {
        $this->parent = $value;
    }

    public function getParentName()
    {
        return $this->parent;
    }

    public function setChildName($value) : void
    {
        $this->child = $value;
    }

    public function getChildName()
    {
        return $this->child;
    }

}
