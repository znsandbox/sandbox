<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;

class PersonEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{

    private $id = null;

    private $code = null;

    private $identityId = null;

    private $firstName = null;

    private $middleName = null;

    private $lastName = null;

    private $birthday = null;

    private $sexId = null;

    private $attributes = [];

    private $contacts = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('code', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('identityId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('identityId', new Assert\Positive());
        $metadata->addPropertyConstraint('firstName', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('middleName', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('lastName', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('birthday', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('sexId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('sexId', new Assert\Positive());
//        $metadata->addPropertyConstraint('attributes', new Assert\NotBlank);
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

    public function setCode($value) : void
    {
        $this->code = $value;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setIdentityId($value) : void
    {
        $this->identityId = $value;
    }

    public function getIdentityId()
    {
        return $this->identityId;
    }

    public function setFirstName($value) : void
    {
        $this->firstName = $value;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setMiddleName($value) : void
    {
        $this->middleName = $value;
    }

    public function getMiddleName()
    {
        return $this->middleName;
    }

    public function setLastName($value) : void
    {
        $this->lastName = $value;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setBirthday($value) : void
    {
        $this->birthday = $value;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setSexId($value) : void
    {
        $this->sexId = $value;
    }

    public function getSexId()
    {
        return $this->sexId;
    }

    public function setAttributes($value) : void
    {
        $this->attributes = $value;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    protected function setAttribute($value, $name) : void
    {
        ArrayHelper::setValue($this->attributes, $name, $value);
    }

    protected function getAttribute($name)
    {
        return ArrayHelper::getValue($this->attributes, $name);
    }

    public function getContacts(): ?Collection
    {
        return $this->contacts;
    }

    public function setContacts(Collection $contacts): void
    {
        $this->contacts = $contacts;
    }
}
