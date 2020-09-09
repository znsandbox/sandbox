<?php

namespace yii2rails\app\domain\filters\config;

use yii2rails\extension\scenario\base\BaseGroupScenario;

class StandardConfigMutations extends BaseGroupScenario {

    public $filters = [
        'yii2rails\app\domain\filters\config\SetControllerNamespace',
        'yii2rails\app\domain\filters\config\FixValidationKeyInTest',
        'yii2rails\app\domain\filters\config\SetAppId',
        'yii2rails\app\domain\filters\config\SetPath',
    ];

}
