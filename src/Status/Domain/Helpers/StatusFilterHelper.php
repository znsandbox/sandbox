<?php

namespace ZnSandbox\Sandbox\Status\Domain\Helpers;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Base\Enum\Constraints\Enum;
use ZnSandbox\Sandbox\Status\Domain\Enums\StatusEnum;

class StatusFilterHelper
{

    public static function loadStatusValidatorMetadata(ClassMetadata $metadata, string $enumStatus = StatusEnum::class, string $attributeName = 'statusId')
    {
        $metadata->addPropertyConstraint($attributeName, new Enum([
            'class' => $enumStatus,
        ]));
    }
}
