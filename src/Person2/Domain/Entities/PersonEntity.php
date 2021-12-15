<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnBundle\Reference\Domain\Constraints\ReferenceItem;
use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnUser\Rbac\Domain\Entities\ItemEntity;

class PersonEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{

    protected $id = null;

    protected $code = null;

    protected $identityId = null;

    protected $firstName = null;

    protected $middleName = null;

    protected $lastName = null;

    protected $birthday = null;

    protected $sexId = null;

//    protected $attributes = [];

    protected $contacts = null;

    protected $sex = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('code', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('identityId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('identityId', new Assert\Positive());
        $metadata->addPropertyConstraint('firstName', new Assert\NotBlank);
        $metadata->addPropertyConstraint('birthday', new Assert\DateTime([
            'format' => 'd.m.Y',
        ]));
//        $metadata->addPropertyConstraint('middleName', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('lastName', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('birthday', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('sexId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('sexId', new Assert\Positive());
        $metadata->addPropertyConstraint('sexId', new ReferenceItem([
            'bookName' => 'sex',
        ]));
//        $metadata->addPropertyConstraint('attributes', new Assert\NotBlank);
    }

    public function unique() : array
    {
        return [
            ['code']
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

    public function setCode($value) : void
    {
        $this->code = $value;
    }

    public function getCode()
    {
        return trim($this->code) ? $this->code : null;
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

    public function getTitle(): string{
        $parentFio =
            $this->getLastName() . ' ' .
            $this->getFirstName() . ' ' .
            $this->getMiddleName();
        $parentFio = StringHelper::removeDoubleSpace($parentFio);
        $parentFio = trim($parentFio);
        return $parentFio;
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

    /*public function setAttributes($value) : void
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
    }*/

    public function getContacts(): ?Collection
    {
        return $this->contacts;
    }

    public function setContacts(?Collection $contacts): void
    {
        $this->contacts = $contacts;
    }

    public function getSex(): ?ItemEntity
    {
        return $this->sex;
    }

    public function setSex(?ItemEntity $sex): void
    {
        $this->sex = $sex;
    }
}
