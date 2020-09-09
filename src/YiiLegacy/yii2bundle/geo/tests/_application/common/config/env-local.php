<?php

use yii\helpers\ArrayHelper;
use yii2tool\test\helpers\TestHelper;

$config = [
	'servers' => [
		'db' => [
			'test' => [
				'driver' => 'sqlite',
				'dbname' => TestHelper::PACKAGE_TEST_DB_FILE,
			],
		],
		'filedb' => [
			'path' => '@tests/_application/common/data',
		],
	],
];

$baseConfig = TestHelper::loadConfig('common/config/env-local.php');
return ArrayHelper::merge($baseConfig, $config);
