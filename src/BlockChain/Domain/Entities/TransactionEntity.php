<?php

namespace ZnSandbox\Sandbox\BlockChain\Domain\Entities;

use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use DateTime;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCrypt\Base\Domain\Enums\HashAlgoEnum;
use ZnSandbox\Sandbox\Grabber\Domain\Libs\Hasher;

class TransactionEntity implements EntityIdInterface, ValidateEntityByMetadataInterface, UniqueInterface
{

    protected $id = null;

    protected $amount = null;

    protected $payload = null;

    protected $digest = null;

    protected $fromAddress = null;

    protected $toAddress = null;

    protected $signature = null;

    protected $createdAt = null;

    public function __construct()
    {
        $this->createdAt = time();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('id', new Assert\Positive());
//        $metadata->addPropertyConstraint('payload', new Assert\NotBlank());
//        $metadata->addPropertyConstraint('digest', new Assert\NotBlank());
        $metadata->addPropertyConstraint('fromAddress', new Assert\NotBlank());
        $metadata->addPropertyConstraint('toAddress', new Assert\NotBlank());
        $metadata->addPropertyConstraint('signature', new Assert\NotBlank());
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank());
    }

    public function unique() : array
    {
        return [
            ['digest']
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    public function setPayload($value) : void
    {
        $this->payload = $value;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setDigest($value) : void
    {
        $this->digest = $value;
    }

    public function getDigest()
    {
        return $this->digest;
    }

    public function setFromAddress($value) : void
    {
        $this->fromAddress = $value;
    }

    public function getFromAddress()
    {
        return $this->fromAddress;
    }

    public function setToAddress($value) : void
    {
        $this->toAddress = $value;
    }

    public function getToAddress()
    {
        return $this->toAddress;
    }

    public function setSignature($value) : void
    {
        $this->signature = $value;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setCreatedAt(int $value) : void
    {
        $this->createdAt = $value;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }


}

