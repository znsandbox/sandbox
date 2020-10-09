<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;

class AttributeEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;

    private $name = null;

    private $type = null;

    private $default = null;

    private $isRequired = null;

    private $title = null;

    private $description = null;

    private $unitId = null;

    private $status = null;

    private $rules;

    private $enums;

    private $unit;

    public function validationRules()
    {
        return [
            'id' => [
                new Assert\NotBlank,
            ],
            'name' => [
                new Assert\NotBlank,
            ],
            'type' => [
                new Assert\NotBlank,
            ],
            'default' => [
                new Assert\NotBlank,
            ],
            'title' => [
                new Assert\NotBlank,
            ],
            'description' => [
                new Assert\NotBlank,
            ],
            'unitId' => [
                new Assert\NotBlank,
            ],
            'status' => [
                new Assert\NotBlank,
            ],
        ];
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($value): void
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($value): void
    {
        $this->type = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setDefault($value): void
    {
        $this->default = $value;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getIsRequired()
    {
        return $this->isRequired;
    }

    public function setIsRequired($isRequired): void
    {
        $this->isRequired = $isRequired;
    }

    public function setTitle($value): void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($value): void
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setUnitId($value): void
    {
        $this->unitId = $value;
    }

    public function getUnitId()
    {
        return $this->unitId;
    }

    public function setStatus($value): void
    {
        $this->status = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return ValidationEntity[]|null|Collection
     */
    public function getRules(): ?Collection
    {
        return $this->rules;
    }

    public function setRules(Collection $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * @return EnumEntity[]|null|Collection
     */
    public function getEnums(): ?Collection
    {
        return $this->enums;
    }

    public function setEnums(Collection $enums): void
    {
        $this->enums = $enums;
    }

    public function getUnit(): ?MeasureEntity
    {
        return $this->unit;
    }

    public function setUnit(MeasureEntity $unit): void
    {
        $this->unit = $unit;
    }

}
