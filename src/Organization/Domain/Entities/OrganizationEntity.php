<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnBundle\Language\Domain\Interfaces\Services\RuntimeLanguageServiceInterface;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Base\Libs\I18Next\Traits\LanguageTrait;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class OrganizationEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{
    use LanguageTrait;

    private $id = null;

    private $title = null;

    private $titleI18n = null;

    private $typeId = null;

    private $description = null;

    private $cityId = null;

    private $regionId = null;

    private $bin = null;

    private $statusId = StatusEnum::ENABLED;

    private $type = null;
    private $locality = null;

    public function __construct(RuntimeLanguageServiceInterface $runtimeLanguageService)
    {
        $this->setRuntimeLanguageService($runtimeLanguageService);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        //$metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('titleI18n', new Assert\NotBlank);
        $metadata->addPropertyConstraint('typeId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank);
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

    public function setTitle($value) : void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->i18n('title');
    }

    public function getTitleI18n()
    {
        return $this->titleI18n;
    }

    public function setTitleI18n($titleI18n): void
    {
        $this->titleI18n = $titleI18n;
    }

    public function setTypeId($value) : void
    {
        $this->typeId = $value;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function getRegionId()
    {
        return $this->regionId;
    }

    public function setRegionId($regionId): void
    {
        $this->regionId = $regionId;
    }

    public function setCityId($cityId): void
    {
        $this->cityId = $cityId;
    }

    public function getBin()
    {
        return $this->bin;
    }

    public function setBin($bin): void
    {
        $this->bin = $bin;
    }

    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function getType(): ?TypeEntity
    {
        return $this->type;
    }

    public function setType(TypeEntity $type): void
    {
        $this->type = $type;
    }

    public function getLocality()
    {
        return $this->locality;
    }

    public function setLocality($locality): void
    {
        $this->locality = $locality;
    }

}
