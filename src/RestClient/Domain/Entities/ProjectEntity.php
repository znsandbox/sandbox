<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Entities;

use ZnCore\Base\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Base\Domain\Interfaces\Entity\ValidateEntityInterface;
use ZnCore\Base\Enums\StatusEnum;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectEntity implements EntityIdInterface, ValidateEntityInterface
{

    private $id = null;
    private $name = null;
    private $title = null;
    private $url = null;
    private $status = StatusEnum::ENABLE;

    public function validationRules(): array
    {
        return [
            'name' => [
                new Assert\NotBlank,
                new Assert\Regex(['pattern' => '/[a-zA-Z0-9-]+/i']),
            ],
            'title' => [
                new Assert\NotBlank,
            ],
            /*'url' => [
                new Assert\NotBlank,
                new Assert\Url,
            ],*/
            'status' => [
                new Assert\NotBlank,
                //new Assert\Choice(StatusEnum::values()),
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

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setUrl($value)
    {
        $this->url = $value;
    }

    public function getUrl()
    {
        return trim($this->url, '/');
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

}
