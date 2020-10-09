<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class MeasureEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;

    private $parentId = null;

    private $name = null;

    private $title = null;

    private $shortTitle = null;

    private $rate = null;

    public function validationRules()
    {
        return [
            'id' => [
                new Assert\NotBlank,
            ],
            'parentId' => [
                new Assert\NotBlank,
            ],
            'name' => [
                new Assert\NotBlank,
            ],
            'title' => [
                new Assert\NotBlank,
            ],
            'shortTitle' => [
                new Assert\NotBlank,
            ],
            'rate' => [
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

    public function setParentId($value) : void
    {
        $this->parentId = $value;
    }

    public function getParentId()
    {
        return $this->parentId;
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

    public function setShortTitle($value) : void
    {
        $this->shortTitle = $value;
    }

    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    public function setRate($value) : void
    {
        $this->rate = $value;
    }

    public function getRate()
    {
        return $this->rate;
    }


}

