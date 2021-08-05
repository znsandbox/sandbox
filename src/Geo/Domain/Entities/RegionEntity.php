<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Libs\I18Next\Traits\LanguageTrait;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class RegionEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{
    use LanguageTrait;

    private $id = null;

    private $countryId = null;

    private $name = null;

    private $nameI18n = null;

    private $localities = null;

    private $country = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('countryId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
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

    public function setCountryId($value) : void
    {
        $this->countryId = $value;
    }

    public function getCountryId()
    {
        return $this->countryId;
    }

    public function setName($value) : void
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->i18n('name');
    }

    public function getNameI18n()
    {
        return $this->nameI18n;
    }

    public function setNameI18n($nameI18n): void
    {
        $this->nameI18n = $nameI18n;
    }

    public function getLocalities()
    {
        return $this->localities;
    }

    public function setLocalities($localities): void
    {
        $this->localities = $localities;
    }

}

