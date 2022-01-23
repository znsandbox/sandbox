<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Entities;

use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use DateTime;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Constraints\Arr;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;

class MetaEntity implements EntityIdInterface, ValidateEntityByMetadataInterface, UniqueInterface
{

    protected $id = null;

    protected $pageId = null;

    protected $title = null;

    protected $siteName = null;

    protected $type = null;

    protected $description = null;

    protected $keywords = null;

    protected $image = null;

    protected $attributes = null;

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
        $metadata->addPropertyConstraint('title', new Assert\NotBlank());
        $metadata->addPropertyConstraint('siteName', new Assert\NotBlank());
        $metadata->addPropertyConstraint('type', new Assert\NotBlank());
        $metadata->addPropertyConstraint('description', new Assert\NotBlank());
        $metadata->addPropertyConstraint('keywords', new Assert\NotBlank());
        $metadata->addPropertyConstraint('image', new Assert\NotBlank());
        $metadata->addPropertyConstraint('attributes', new Assert\NotBlank());
        $metadata->addPropertyConstraint('attributes', new Arr());
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

    public function setTitle($value) : void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setSiteName($value) : void
    {
        $this->siteName = $value;
    }

    public function getSiteName()
    {
        return $this->siteName;
    }

    public function setType($value) : void
    {
        $this->type = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setDescription($value) : void
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setKeywords($value) : void
    {
        $this->keywords = $value;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setImage($value) : void
    {
        $this->image = $value;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setAttributes($value) : void
    {
        $this->attributes = $value;
    }

    public function getAttributes()
    {
        return $this->attributes;
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

