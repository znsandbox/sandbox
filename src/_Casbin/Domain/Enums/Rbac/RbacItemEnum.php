<?php

namespace ZnUser\Rbac\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;

class RbacItemEnum implements GetLabelsInterface
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
            self::ALL => 'RBAC роли и полномочия. Просмотр списка',
            self::ONE => 'RBAC роли и полномочия. Просмотр записи',
            self::CREATE => 'RBAC роли и полномочия. Создание',
            self::UPDATE => 'RBAC роли и полномочия. Редактирование',
            self::DELETE => 'RBAC роли и полномочия. Удаление',
//            self::RESTORE => 'RBAC item. Восстановление',
        ];
    }
}