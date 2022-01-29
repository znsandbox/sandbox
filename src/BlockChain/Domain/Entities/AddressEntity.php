<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Entities;

use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;

class AddressEntity implements EntityIdInterface, ValidateEntityByMetadataInterface, UniqueInterface
{

    protected $id = null;

    protected $address = null;

    protected $publicKey = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Positive());
        $metadata->addPropertyConstraint('address', new Assert\NotBlank());
        $metadata->addPropertyConstraint('publicKey', new Assert\NotBlank());
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

    public function setAddress($value) : void
    {
        $this->address = $value;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setPublicKey($value) : void
    {
        $this->publicKey = $value;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }


}

