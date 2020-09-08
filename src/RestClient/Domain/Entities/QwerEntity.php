<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Base\Domain\Interfaces\Entity\ValidateEntityInterface;

class QwerEntity implements ValidateEntityInterface
{

    private $title = null;

    public function validationRules()
    {
        return [];
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }


}

