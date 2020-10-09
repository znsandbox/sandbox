<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Entities;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;

class EntityEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;

    private $bookId = null;

    private $name = null;

    private $title = null;

    private $handler = null;

    private $status = null;

    private $attributes = null;

    public function validationRules()
    {
        return [
            'id' => [
                new Assert\NotBlank,
            ],
            'bookId' => [
                new Assert\NotBlank,
            ],
            'name' => [
                new Assert\NotBlank,
            ],
            'title' => [
                new Assert\NotBlank,
            ],
            'handler' => [
                new Assert\NotBlank,
            ],
            'status' => [
                new Assert\NotBlank,
            ],
        ];
    }

    public function getAttributeNames()
    {
        return EntityHelper::getColumn($this->getAttributes(), 'name');
    }

    public function getRules()
    {
        $attributesCollection = $this->getAttributes();
        $rules = [];
        /** @var AttributeEntity $attributeEntity */
        foreach ($attributesCollection as $attributeEntity) {
            $attributeName = $attributeEntity->getName();
            foreach ($attributeEntity->getRules() as $ruleEntity) {
                $ruleName = $ruleEntity->getName();
                $isClassName = strpos($ruleName, '\\') !== false;
                $ruleClassName = $isClassName ? $ruleName : 'Symfony\Component\Validator\Constraints\\' . ucfirst($ruleName);
                if ($ruleClassName) {
                    $rules[$attributeName][] = new $ruleClassName;
                }
            }
            $enumCollection = $attributeEntity->getEnums();
            if ($enumCollection && $enumCollection->count() > 0) {
                $rules[$attributeName][] = new Assert\Choice([
                    'choices' => EntityHelper::getColumn($enumCollection, 'name'),
                ]);
            }
            if($attributeEntity->getIsRequired()) {
                $rules[$attributeName][] = new Assert\NotBlank;
            }
        }
        return $rules;
    }

    public function setId($value): void
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setBookId($value): void
    {
        $this->bookId = $value;
    }

    public function getBookId()
    {
        return $this->bookId;
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

    public function setHandler($value): void
    {
        $this->handler = $value;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function setStatus($value): void
    {
        $this->status = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Collection|null|AttributeEntity[]
     */
    public function getAttributes(): ?Collection
    {
        return $this->attributes;
    }

    public function setAttributes(Collection $attributes): void
    {
        $this->attributes = $attributes;
    }
}
