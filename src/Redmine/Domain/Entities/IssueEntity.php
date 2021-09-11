<?php

namespace ZnSandbox\Sandbox\Redmine\Domain\Entities;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;
use ZnCore\Domain\Interfaces\Entity\UniqueInterface;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;

class IssueEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface
{

    private $id = null;

    private $projectId = null;

    private $trackerId = null;

    private $statusId = null;

    private $priorityId = null;

    private $authorId = null;

    private $assignedId = null;

    private $subject = null;

    private $description = null;

    private $startDate = null;

    private $doneRatio = null;

    private $createdAt = null;

    private $updatedAt = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('projectId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('trackerId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('priorityId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('authorId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('assignedId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('subject', new Assert\NotBlank);
        $metadata->addPropertyConstraint('description', new Assert\NotBlank);
        $metadata->addPropertyConstraint('startDate', new Assert\NotBlank);
        $metadata->addPropertyConstraint('doneRatio', new Assert\NotBlank);
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank);
        $metadata->addPropertyConstraint('updatedAt', new Assert\NotBlank);
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

    public function setProjectId($value) : void
    {
        $this->projectId = $value;
    }

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function setTrackerId($value) : void
    {
        $this->trackerId = $value;
    }

    public function getTrackerId()
    {
        return $this->trackerId;
    }

    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function setPriorityId($value) : void
    {
        $this->priorityId = $value;
    }

    public function getPriorityId()
    {
        return $this->priorityId;
    }

    public function setAuthorId($value) : void
    {
        $this->authorId = $value;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function setAssignedId($value) : void
    {
        $this->assignedId = $value;
    }

    public function getAssignedId()
    {
        return $this->assignedId;
    }

    public function setSubject($value) : void
    {
        $this->subject = $value;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setDescription($value) : void
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setStartDate($value) : void
    {
        $this->startDate = $value;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setDoneRatio($value) : void
    {
        $this->doneRatio = $value;
    }

    public function getDoneRatio()
    {
        return $this->doneRatio;
    }

    public function setCreatedAt($value) : void
    {
        $this->createdAt = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($value) : void
    {
        $this->updatedAt = $value;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


}

