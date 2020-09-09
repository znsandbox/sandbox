<?php

namespace yii2bundle\geo\domain\enums;

use yii2rails\extension\enum\base\BaseEnum;

class GeoPermissionEnum extends BaseEnum
{

    // Управление городами
    const CITY_MANAGE = 'oGeoCityManage';

    // Управление странами
    const COUNTRY_MANAGE = 'oGeoCountryManage';

    // Управление валютами
    const CURRENCY_MANAGE = 'oGeoCurrencyManage';

    // Управление регионами
    const REGION_MANAGE = 'oGeoRegionManage';

}