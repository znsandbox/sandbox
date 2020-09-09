<?php

namespace yii2rails\app\admin;

use yii\base\Module as YiiModule;
use yii2rails\app\domain\enums\AppPermissionEnum;
use yii2rails\extension\web\helpers\Behavior;

/**
 * dashboard module definition class
 */
class Module extends YiiModule
{

    public function behaviors()
    {
        return [
            'access' => Behavior::access(AppPermissionEnum::CONFIG),
        ];
    }
}
