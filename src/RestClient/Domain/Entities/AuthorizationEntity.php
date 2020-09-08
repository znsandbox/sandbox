<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Entities;

use ZnCore\Base\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Base\Domain\Interfaces\Entity\ValidateEntityInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorizationEntity implements EntityIdInterface, ValidateEntityInterface
{

    private $id = null;
    private $projectId = null;
    private $type = null;
    private $username = null;
    private $password = null;

    public function validationRules(): array
    {
        return [
            'projectId' => [
                new Assert\NotBlank,
                new Assert\Positive,
            ],
            'type' => [
                new Assert\NotBlank,
            ],
            'username' => [
                new Assert\NotBlank,
            ],
        ];
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setProjectId($value)
    {
        $this->projectId = $value;
    }

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function setType($value)
    {
        $this->type = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setUsername($value)
    {
        $this->username = $value;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($value)
    {
        $this->password = $value;
    }

    public function getPassword()
    {
        return $this->password;
    }

}

