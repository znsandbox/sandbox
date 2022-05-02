<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Enums\Rbac;

use ZnCore\Contract\Enum\Interfaces\GetLabelsInterface;
use ZnCore\Contract\Rbac\Interfaces\GetRbacInheritanceInterface;
use ZnCore\Contract\Rbac\Traits\CrudRbacInheritanceTrait;

class GeoLocalityPermissionEnum implements GetLabelsInterface, GetRbacInheritanceInterface
{

    use CrudRbacInheritanceTrait;

    const CRUD = 'oGeoLocalityCrud';
    const ALL = 'oGeoLocalityAll';
    const ONE = 'oGeoLocalityOne';
    const CREATE = 'oGeoLocalityCreate';
    const UPDATE = 'oGeoLocalityUpdate';
    const DELETE = 'oGeoLocalityDelete';
//    const RESTORE = 'oGeoLocalityRestore';

    public static function getLabels()
    {
        return [
            self::CRUD => 'Населенный пункт. Полный доступ',
            self::ALL => 'Населенный пункт. Просмотр списка',
            self::ONE => 'Населенный пункт. Просмотр записи',
            self::CREATE => 'Населенный пункт. Создание',
            self::UPDATE => 'Населенный пункт. Редактирование',
            self::DELETE => 'Населенный пункт. Удаление',
//            self::RESTORE => 'Населенный пункт. Восстановление',
        ];
    }
}