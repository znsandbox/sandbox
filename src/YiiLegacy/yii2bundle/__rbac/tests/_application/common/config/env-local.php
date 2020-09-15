<?php

use yii\helpers\ArrayHelper;
use yii2tool\test\helpers\TestHelper;

$config = [
	'servers' => [
		'filedb' => [
			'path' => '@yii2bundle/account/domain/v3/fixtures/data',
		],
	],
];

$baseConfig = TestHelper::loadConfig('common/config/env-local.php');
return ArrayHelper::merge($baseConfig, $config);
