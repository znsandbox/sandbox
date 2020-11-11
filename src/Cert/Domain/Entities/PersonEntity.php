<?php

namespace ZnSandbox\Sandbox\Cert\Domain\Entities;

use ZnCore\Base\Helpers\StringHelper;

class PersonEntity
{

    private $name;
    private $surname;
    private $patronymic;
    private $code;
    private $email;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    public function getPatronymic()
    {
        return $this->patronymic;
    }

    public function setPatronymic($patronymic): void
    {
        $this->patronymic = $patronymic;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code): void
    {
        $this->code = $code;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }
}
