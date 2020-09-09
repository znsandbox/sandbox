<?php

use yii\helpers\ArrayHelper;
use yii2tool\test\helpers\TestHelper;
use yii2rails\domain\enums\Driver;
use yii2bundle\rbac\domain\repositories\disc\ItemRepository;
use yii2bundle\rbac\domain\repositories\disc\RuleRepository;

$config = [
    'rbac' => [
	    'class' => 'yii2bundle\rbac\domain\Domain',
        'repositories' => [
            'rule' => [
                'ruleFile' => '@vendor/yii2tool/yii2-test/src/base/_application/common/data/rbac/rules.php',
            ],
            'item' => [
                'itemFile' => '@vendor/yii2tool/yii2-test/src/base/_application/common/data/rbac/items.php',
            ],
        ],
    ],
];

$baseConfig = TestHelper::loadConfig('common/config/domains.php');
return ArrayHelper::merge($baseConfig, $config);
