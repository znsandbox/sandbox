<?php

namespace ZnSandbox\Sandbox\Status\Domain\Filters;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use ZnCore\Domain\Interfaces\Entity\ValidateEntityByMetadataInterface;

class StatusFilter extends BaseStatusFilter implements ValidateEntityByMetadataInterface
{

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        self::loadStatusValidatorMetadata($metadata);
    }
}
