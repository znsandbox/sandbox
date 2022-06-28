<?php

namespace ZnSandbox\Sandbox\Wsdl\Domain\Entities;

use ZnCore\Domain\Entity\Interfaces\EntityIdInterface;
use ZnCore\Base\Validation\Interfaces\ValidationByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Entity\Interfaces\UniqueInterface;

class ServiceEntity implements EntityIdInterface, ValidationByMetadataInterface, UniqueInterface
{

    protected $id = null;

    protected $name = null;

    protected $path = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Positive());
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('path', new Assert\NotBlank());
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

    public function setName($value) : void
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPath($value) : void
    {
        $this->path = $value;
    }

    public function getPath()
    {
        return $this->path;
    }


}

