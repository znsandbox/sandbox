<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Forms;

use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SiteForm implements ValidateEntityByMetadataInterface
{

    protected $domain = null;

    protected $title = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('domain', new Assert\NotBlank());
        $metadata->addPropertyConstraint('title', new Assert\NotBlank());
    }

    public function setDomain($value) : void
    {
        $this->domain = $value;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setTitle($value) : void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }


}

