<?php

namespace ZnSandbox\Sandbox\UserSecurity\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;

class SecurityPermissionEnum implements GetLabelsInterface
{

    const RESTORE_PASSWORD_REQUEST_ACTIVATION_CODE = 'oRestorePasswordRequestActivationCode';
    const RESTORE_PASSWORD_CREATE_PASSWORD = 'oRestorePasswordCreatePassword';
    const UPDATE_PASSWORD_UPDATE = 'oUpdatePasswordUpdate';

    public static function getLabels()
    {
        return [
            self::RESTORE_PASSWORD_REQUEST_ACTIVATION_CODE => 'Восстановление пароля. Запроса кода активации',
            self::RESTORE_PASSWORD_CREATE_PASSWORD => 'Восстановление пароля. Создание пароля',
            self::UPDATE_PASSWORD_UPDATE => 'Изменение пароля',
        ];
    }
}