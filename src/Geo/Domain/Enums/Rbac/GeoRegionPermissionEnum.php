<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Enums\Rbac;

use ZnCore\Contract\Enum\Interfaces\GetLabelsInterface;
use ZnCore\Contract\Rbac\Interfaces\GetRbacInheritanceInterface;
use ZnCore\Contract\Rbac\Traits\CrudRbacInheritanceTrait;

class GeoRegionPermissionEnum implements GetLabelsInterface, GetRbacInheritanceInterface
{

    use CrudRbacInheritanceTrait;

    const CRUD = 'oGeoRegionCrud';
    const ALL = 'oGeoRegionAll';
    const ONE = 'oGeoRegionOne';
    const CREATE = 'oGeoRegionCreate';
    const UPDATE = 'oGeoRegionUpdate';
    const DELETE = 'oGeoRegionDelete';
//    const RESTORE = 'oGeoRegionRestore';

    public static function getLabels()
    {
        return [
            self::CRUD => 'Регион. Полный доступ',
            self::ALL => 'Регион. Просмотр списка',
            self::ONE => 'Регион. Просмотр записи',
            self::CREATE => 'Регион. Создание',
            self::UPDATE => 'Регион. Редактирование',
            self::DELETE => 'Регион. Удаление',
//            self::RESTORE => 'Регион. Восстановление',
        ];
    }
}