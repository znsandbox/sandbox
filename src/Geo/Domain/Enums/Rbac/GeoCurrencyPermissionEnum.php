<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Enums\Rbac;

use ZnCore\Base\Interfaces\GetLabelsInterface;
use ZnCore\Contract\Rbac\Interfaces\GetRbacInheritanceInterface;
use ZnCore\Contract\Rbac\Traits\CrudRbacInheritanceTrait;

class GeoCurrencyPermissionEnum implements GetLabelsInterface, GetRbacInheritanceInterface
{

    use CrudRbacInheritanceTrait;

    const CRUD = 'oGeoCurrencyCrud';
    const ALL = 'oGeoCurrencyAll';
    const ONE = 'oGeoCurrencyOne';
    const CREATE = 'oGeoCurrencyCreate';
    const UPDATE = 'oGeoCurrencyUpdate';
    const DELETE = 'oGeoCurrencyDelete';
//    const RESTORE = 'oGeoCurrencyRestore';

    public static function getLabels()
    {
        return [
            self::CRUD => 'Валюта. Полный доступ',
            self::ALL => 'Валюта. Просмотр списка',
            self::ONE => 'Валюта. Просмотр записи',
            self::CREATE => 'Валюта. Создание',
            self::UPDATE => 'Валюта. Редактирование',
            self::DELETE => 'Валюта. Удаление',
//            self::RESTORE => 'Валюта. Восстановление',
        ];
    }
}