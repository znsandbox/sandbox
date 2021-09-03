<?php

namespace ZnSandbox\Sandbox\RpcClient\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Legacy\Yii\Helpers\StringHelper;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class FavoriteEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{

    private $id = null;

    private $uid = null;

    private $method = null;

    private $body = null;

    private $meta = null;

    private $authBy = null;

    private $description = null;

    private $authorId = null;

    private $statusId = StatusEnum::ENABLED;

    private $createdAt = null;

    private $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('uid', new Assert\NotBlank);
        $metadata->addPropertyConstraint('method', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('body', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('meta', new Assert\NotBlank);
        $metadata->addPropertyConstraint('authorId', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('description', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('updatedAt', new Assert\NotBlank);
    }

    public function unique() : array
    {
        return [
            ['uid'],
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

    public function setUid($value) : void
    {
        $this->uid = $value;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setMethod($value) : void
    {
        $this->method = $value;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setBody($value) : void
    {
        $this->body = $value;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setMeta($value) : void
    {
        $this->meta = $value;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setAuthBy($value) : void
    {
        $this->authBy = $value;
    }

    public function getAuthBy()
    {
        return $this->authBy;
    }

    public function setDescription($value) : void
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function setAuthorId($authorId): void
    {
        $this->authorId = $authorId;
    }

    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
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
}
