<?php

namespace yii2bundle\account\domain\v3\enums;

use ZnCore\Domain\Base\BaseEnum;

class AccountPermissionEnum extends BaseEnum
{

    const IDENTITY_READ = 'oAccountIdentityRead';
    const IDENTITY_WRITE = 'oAccountIdentityWrite';

    public static function getLabels() {
        return [
            self::IDENTITY_READ => 'Пользователь. Чтение',
            self::IDENTITY_WRITE => 'Пользователь. Запись',
        ];
    }
}