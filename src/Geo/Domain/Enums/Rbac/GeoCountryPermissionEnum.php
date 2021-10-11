<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;
use ZnCore\Contract\Rbac\Interfaces\GetRbacInheritanceInterface;
use ZnCore\Contract\Rbac\Traits\CrudRbacInheritanceTrait;

class GeoCountryPermissionEnum implements GetLabelsInterface, GetRbacInheritanceInterface
{

    use CrudRbacInheritanceTrait;

    const CRUD = 'oGeoCountryCrud';
    const ALL = 'oGeoCountryAll';
    const ONE = 'oGeoCountryOne';
    const CREATE = 'oGeoCountryCreate';
    const UPDATE = 'oGeoCountryUpdate';
    const DELETE = 'oGeoCountryDelete';
//    const RESTORE = 'oGeoCountryRestore';

    public static function getLabels()
    {
        return [
            self::CRUD => 'Страна. Полный доступ',
            self::ALL => 'Страна. Просмотр списка',
            self::ONE => 'Страна. Просмотр записи',
            self::CREATE => 'Страна. Создание',
            self::UPDATE => 'Страна. Редактирование',
            self::DELETE => 'Страна. Удаление',
//            self::RESTORE => 'Страна. Восстановление',
        ];
    }
}