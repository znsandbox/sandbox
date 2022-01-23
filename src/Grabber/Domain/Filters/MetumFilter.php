<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Filters;

use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Constraints\Arr;

class MetumFilter implements ValidateEntityByMetadataInterface
{

    protected $pageId = null;

    protected $title = null;

    protected $siteName = null;

    protected $type = null;

    protected $description = null;

    protected $keywords = null;

    protected $image = null;

    protected $attributes = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('pageId', new Assert\Positive());
        $metadata->addPropertyConstraint('attributes', new Arr());
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


}

