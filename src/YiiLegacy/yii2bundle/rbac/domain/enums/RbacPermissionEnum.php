<?php

namespace yii2bundle\rbac\domain\enums;

use ZnCore\Base\Domain\Base\BaseEnum;

class RbacPermissionEnum extends BaseEnum
{

    const MANAGE = 'oRbacManage';
	const AUTHORIZED = '@';
	const GUEST = '?';

    public static function getLabels() {
        return [
            self::MANAGE => 'Управление RBAC',
            self::AUTHORIZED => 'Авторизованный',
            self::GUEST => 'Гость',
        ];
    }

}