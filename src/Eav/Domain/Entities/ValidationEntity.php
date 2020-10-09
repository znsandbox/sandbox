<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class ValidationEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;

    private $attributeId = null;

    private $name = null;

    private $params = null;

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
            'params' => [
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

    public function setParams($value) : void
    {
        $this->params = $value;
    }

    public function getParams()
    {
        return $this->params;
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

