<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Filters;

use ZnSandbox\Sandbox\Status\Domain\Filters\BaseStatusFilter;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class HistoryFilter extends BaseStatusFilter
{

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        self::loadStatusValidatorMetadata($metadata);
    }
}
