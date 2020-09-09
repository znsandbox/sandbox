<?php

namespace yii2bundle\rest\domain\rules;

use Yii;

class UrlRule extends \yii\rest\UrlRule {

    public $tokens = [
        '{id}' => '<id:[^\/]+>',
    ];

}
