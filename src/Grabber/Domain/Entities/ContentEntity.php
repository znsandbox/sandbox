<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Entities;

use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use DateTime;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;

class ContentEntity implements EntityIdInterface, ValidateEntityByMetadataInterface, UniqueInterface
{

    protected $id = null;

    protected $pageId = null;

    protected $content = null;

    protected $createdAt = null;

    protected $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('id', new Assert\Positive());
        $metadata->addPropertyConstraint('pageId', new Assert\NotBlank());
        $metadata->addPropertyConstraint('pageId', new Assert\Positive());
        $metadata->addPropertyConstraint('content', new Assert\NotBlank());
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank());
//        $metadata->addPropertyConstraint('updatedAt', new Assert\NotBlank());
    }

    public function unique() : array
    {
        return [
            ['page_id']
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

    public function setPageId($value) : void
    {
        $this->pageId = $value;
    }

    public function getPageId()
    {
        return $this->pageId;
    }

    public function setContent($value) : void
    {
        $this->content = $value;
    }

    public function getContent()
    {
        return $this->content;
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

