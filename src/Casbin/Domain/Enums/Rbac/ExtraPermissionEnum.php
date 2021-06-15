<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;

class ExtraPermissionEnum implements GetLabelsInterface
{

    const ADMIN_ONLY = 'oAdminOnly';

    public static function getLabels()
    {
        return [
            self::ADMIN_ONLY => 'Доступ только для админа',
        ];
    }
}