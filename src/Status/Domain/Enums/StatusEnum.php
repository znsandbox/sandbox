<?php

namespace ZnSandbox\Sandbox\Status\Domain\Enums;

use ZnCore\Enum\Interfaces\GetLabelsInterface;
use ZnLib\Components\I18Next\Facades\I18Next;

class StatusEnum implements GetLabelsInterface
{

    const ENABLED = 100;
    const DELETED = -10;

    public static function getLabels()
    {
        return [
            self::DELETED => I18Next::t('core', 'status.deleted'),
            self::ENABLED => I18Next::t('core', 'status.enabled'),
        ];
    }
}
