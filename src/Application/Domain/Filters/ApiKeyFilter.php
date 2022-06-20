<?php

namespace ZnSandbox\Sandbox\Application\Domain\Filters;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Libs\Entity\Interfaces\ValidateEntityByMetadataInterface;

class ApiKeyFilter implements ValidateEntityByMetadataInterface
{

    protected $applicationId;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('applicationId', new Assert\NotBlank());
        $metadata->addPropertyConstraint('applicationId', new Assert\Positive());
    }

    public function getApplicationId()
    {
        return $this->applicationId;
    }

    public function setApplicationId($applicationId): void
    {
        $this->applicationId = $applicationId;
    }
}
