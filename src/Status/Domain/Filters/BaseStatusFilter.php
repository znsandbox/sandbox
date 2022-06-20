<?php

namespace ZnSandbox\Sandbox\Status\Domain\Filters;

use ZnCore\Base\Libs\Enum\Constraints\Enum;
use ZnSandbox\Sandbox\Status\Domain\Enums\StatusEnum;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Libs\Enum\Helpers\EnumHelper;
use ZnCore\Base\Libs\Validation\Interfaces\ValidationByMetadataInterface;
use ZnSandbox\Sandbox\Status\Domain\Helpers\StatusFilterHelper;

abstract class BaseStatusFilter implements ValidationByMetadataInterface
{

    /*protected $statusId = StatusEnum::ENABLED;

    protected static function loadStatusValidatorMetadata(ClassMetadata $metadata, string $enumStatus = StatusEnum::class)
    {
//        StatusFilterHelper::loadStatusValidatorMetadata($metadata, $enumStatus);
        $metadata->addPropertyConstraint('statusId', new Enum([
            'class' => $enumStatus,
        ]));
    }

    public function setStatusId(int $value): void
    {
        $this->statusId = $value;
    }

    public function getStatusId()
    {
        return $this->statusId;
    }*/
}
