<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Enums;

use ZnCore\Base\Interfaces\GetLabelsInterface;

class RbacRoleEnum implements GetLabelsInterface
{

    const AUTHORIZED = '@';
    const GUEST = '?';

    public static function getLabels()
    {
        return [
            self::AUTHORIZED => 'Авторизованный',
            self::GUEST => 'Гость',
        ];
    }

}