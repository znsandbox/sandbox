<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class EnvironmentEntity implements ValidateEntityInterface, EntityIdInterface
{

    private $id = null;
    private $projectId = null;
    private $isMain = false;
    private $title = null;
    private $url = null;

    public function validationRules()
    {
        return [
            /*'id' => [
                new Assert\NotBlank,
            ],*/
            'title' => [
                new Assert\NotBlank,
            ],
            'url' => [
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

    public function setProjectId($value) : void
    {
        $this->projectId = $value;
    }

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function getIsMain()
    {
        return $this->isMain;
    }

    public function setIsMain($isMain)
    {
        $this->isMain = $isMain;
    }

    public function setTitle($value) : void
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setUrl($value) : void
    {
        $this->url = $value;
    }

    public function getUrl()
    {
        return $this->url;
    }

}
