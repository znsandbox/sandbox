<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Enums\Rbac;

use ZnCore\Base\Libs\Enum\Interfaces\GetLabelsInterface;

class AppPersonPermissionEnum implements GetLabelsInterface
{

    const PERSON_INFO_UPDATE = 'oPersonInfoUpdate';
    const PERSON_INFO_ONE = 'oPersonInfoOne';

    public static function getLabels()
    {
        return [
            self::PERSON_INFO_UPDATE => 'Персона. Изменение данных',
            self::PERSON_INFO_ONE => 'Персона. Чтение данных',
        ];
    }
}