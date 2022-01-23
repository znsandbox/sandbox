<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Filters;

use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ContentFilter implements ValidateEntityByMetadataInterface
{

    protected $pageId = null;

    protected $content = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('pageId', new Assert\Positive());
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


}

