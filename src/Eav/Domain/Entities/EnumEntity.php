<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class EnumEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;

    private $attributeId = null;

    private $name = null;

    private $title = null;

    private $sort = null;

    private $status = null;

    public function validationRules()
    {
        return [
            'id' => [
                new Assert\NotBlank,
            ],
            'attributeId' => [
                new Assert\NotBlank,
            ],
            'name' => [
                new Assert\NotBlank,
            ],
            'title' => [
                new Assert\NotBlank,
            ],
            'sort' => [
                new Assert\NotBlank,
            ],
            'status' => [
                new Assert\NotBlank,
            ],
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

    public function setattributeId($value) : void
    {
        $this->attributeId = $value;
    }

    public function getattributeId()
    {
        return $this->attributeId;
    }

    public function setName($value) : void
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTitle($value) : void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setSort($value) : void
    {
        $this->sort = $value;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setStatus($value) : void
    {
        $this->status = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }


}

