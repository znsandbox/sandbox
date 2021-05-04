<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class InheritanceEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{

    private $id = null;

    private $parent = null;

    private $child = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('parent', new Assert\NotBlank);
        $metadata->addPropertyConstraint('child', new Assert\NotBlank);
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

    public function setParent($value) : void
    {
        $this->parent = $value;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setChild($value) : void
    {
        $this->child = $value;
    }

    public function getChild()
    {
        return $this->child;
    }


}

