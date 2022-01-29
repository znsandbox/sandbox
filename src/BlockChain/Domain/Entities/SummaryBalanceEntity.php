<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Entities;

use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;

class SummaryBalanceEntity implements EntityIdInterface, ValidateEntityByMetadataInterface, UniqueInterface
{

    protected $id = null;

    protected $address = null;

    protected $balance = null;

    protected $updatedAt = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Positive());
        $metadata->addPropertyConstraint('address', new Assert\NotBlank());
        $metadata->addPropertyConstraint('balance', new Assert\NotBlank());
        $metadata->addPropertyConstraint('updatedAt', new Assert\NotBlank());
    }

    public function unique() : array
    {
        return [
            ['address']
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

    public function setAddress($value) : void
    {
        $this->address = $value;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setBalance($value) : void
    {
        $this->balance = $value;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function setUpdatedAt($value) : void
    {
        $this->updatedAt = $value;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


}

