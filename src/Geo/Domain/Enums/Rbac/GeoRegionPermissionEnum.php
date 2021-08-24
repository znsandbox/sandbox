<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;

class GeoRegionPermissionEnum implements GetLabelsInterface
{

    const ALL = 'oGeoRegionAll';
    const ONE = 'oGeoRegionOne';
    const CREATE = 'oGeoRegionCreate';
    const UPDATE = 'oGeoRegionUpdate';
    const DELETE = 'oGeoRegionDelete';
//    const RESTORE = 'oGeoRegionRestore';

    public static function getLabels()
    {
        return [
            self::ALL => 'Регион. Просмотр списка',
            self::ONE => 'Регион. Просмотр записи',
            self::CREATE => 'Регион. Создание',
            self::UPDATE => 'Регион. Редактирование',
            self::DELETE => 'Регион. Удаление',
//            self::RESTORE => 'Регион. Восстановление',
        ];
    }
}