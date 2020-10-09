<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;

class CategoryEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;

    private $name = null;

    private $title = null;

    public function validationRules()
    {
        return [
            'id' => [
                new Assert\NotBlank,
            ],
            'name' => [
                new Assert\NotBlank,
            ],
            'title' => [
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

    public function setTitle($value): void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }


}

