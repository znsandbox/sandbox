<?php

use yii\helpers\ArrayHelper;
use yii2tool\test\helpers\TestHelper;
use yii2bundle\lang\domain\enums\LanguageEnum;

$config = [
	'language' => LanguageEnum::RU, // current Language
	'bootstrap' => ['log', 'language', 'queue'],
	'components' => [
		'language' => 'yii2bundle\lang\domain\components\Language',
	],
];

$baseConfig = TestHelper::loadConfig('common/config/main.php');
return ArrayHelper::merge($baseConfig, $config);
