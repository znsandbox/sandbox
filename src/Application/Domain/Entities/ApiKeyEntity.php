<?php

namespace ZnSandbox\Sandbox\Application\Domain\Entities;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Enums\StatusEnum;
use ZnCore\Domain\Constraints\Enum;
use ZnCore\Base\Libs\Entity\Interfaces\ValidateEntityByMetadataInterface;
use ZnCore\Base\Libs\Entity\Interfaces\UniqueInterface;
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;
use ZnLib\Web\Symfony4\MicroApp\Interfaces\BuildFormInterface;

class ApiKeyEntity implements ValidateEntityByMetadataInterface, UniqueInterface, EntityIdInterface, BuildFormInterface
{

    private $id = null;

    private $title = null;

    private $applicationId = null;

    private $value = null;

    private $statusId = StatusEnum::ENABLED;

    private $createdAt = null;

    private $expiredAt = null;

    private $application = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
//        $metadata->addPropertyConstraint('id', new Assert\NotBlank);
        $metadata->addPropertyConstraint('applicationId', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('value', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Assert\NotBlank);
        $metadata->addPropertyConstraint('statusId', new Enum([
            'class' => StatusEnum::class,
        ]));
        $metadata->addPropertyConstraint('createdAt', new Assert\NotBlank);
//        $metadata->addPropertyConstraint('expiredAt', new Assert\NotBlank);
    }

    public function buildForm(FormBuilderInterface $formBuilder)
    {
        $formBuilder
            ->add('applicationId', TextType::class, [
                'label' => 'applicationId'
            ])
            /*->add('value', TextType::class, [
                'label' => 'value'
            ])*/
            ->add('expiredAt', TextType::class, [
                'label' => 'expiredAt'
            ])
        ;
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

    public function getTitle()
    {
        if($this->getApplication()) {
            return $this->getApplication()->getTitle();
        }
        return $this->getId();
    }

    public function setTitle($title): void
    {
        //$this->title = $title;
    }

    public function setApplicationId($value) : void
    {
        $this->applicationId = $value;
    }

    public function getApplicationId()
    {
        return $this->applicationId;
    }

    public function setValue($value) : void
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setStatusId($value) : void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }

    public function setCreatedAt($value) : void
    {
        $this->createdAt = $value;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setExpiredAt($value) : void
    {
        $this->expiredAt = $value;
    }

    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    public function getApplication(): ?ApplicationEntity
    {
        return $this->application;
    }

    public function setApplication(ApplicationEntity $application): void
    {
        $this->application = $application;
    }
}
