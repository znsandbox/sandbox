<?php

namespace ZnSandbox\Telegram\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Base\Domain\Interfaces\Entity\ValidateEntityInterface;
use ZnCore\Base\Domain\Interfaces\Entity\EntityIdInterface;

class UserTelegramEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;

    private $login = null;

    private $identityId = null;
    private $update = null;

    public function validationRules()
    {
        return [
            'id' => [
                new Assert\NotBlank,
            ],
            'login' => [
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

    /**
     * @return null
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param null $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return null
     */
    public function getIdentityId()
    {
        return $this->identityId;
    }

    /**
     * @param null $identityId
     */
    public function setIdentityId($identityId): void
    {
        $this->identityId = $identityId;
    }

    /**
     * @return null
     */
    public function getUpdate()
    {
        return $this->update;
    }

    /**
     * @param null $update
     */
    public function setUpdate($update): void
    {
        $this->update = $update;
    }

}

