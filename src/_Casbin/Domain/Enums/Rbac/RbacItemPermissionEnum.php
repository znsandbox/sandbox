<?php

namespace ZnUser\Rbac\Domain\Enums\Rbac;

use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Interfaces\GetLabelsInterface;

DeprecateHelper::softThrow();

/**
 * Class RbacItemPermissionEnum
 * @package ZnUser\Rbac\Domain\Enums\Rbac
 * @deprecated
 * @see RbacItemEnum
 */
class RbacItemPermissionEnum implements GetLabelsInterface
{

    const ALL = 'oRbacItemAll';
    const ONE = 'oRbacItemOne';
    const CREATE = 'oRbacItemCreate';
    const UPDATE = 'oRbacItemUpdate';
    const DELETE = 'oRbacItemDelete';
//    const RESTORE = 'oRbacItemRestore';

    public static function getLabels()
    {
        return [
            self::ALL => 'RBAC item. Просмотр списка',
            self::ONE => 'RBAC item. Просмотр записи',
            self::CREATE => 'RBAC item. Создание',
            self::UPDATE => 'RBAC item. Редактирование',
            self::DELETE => 'RBAC item. Удаление',
//            self::RESTORE => 'RBAC item. Восстановление',
        ];
    }
}