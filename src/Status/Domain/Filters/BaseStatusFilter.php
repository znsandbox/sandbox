<?php

namespace ZnSandbox\Sandbox\Status\Domain\Filters;

use ZnSandbox\Sandbox\Status\Domain\Enums\StatusEnum;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Helpers\EnumHelper;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

abstract class BaseStatusFilter implements ValidateEntityByMetadataInterface
{

    protected $statusId = StatusEnum::ENABLED;

    protected static function loadStatusValidatorMetadata(ClassMetadata $metadata, string $enumStatus = StatusEnum::class)
    {
        $metadata->addPropertyConstraint('statusId', new Assert\Choice([
            'choices' => EnumHelper::getValues($enumStatus)
        ]));
    }

    public function setStatusId(int $value): void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }
}
