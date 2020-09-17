<?php

namespace yii2rails\extension\code\helpers\generator;

use yii\helpers\ArrayHelper;

class EnumGeneratorHelper {
	
	private static $defaultConfig = [
		'use' => ['ZnCore\Domain\Base\BaseEnum'],
		'afterClassName' => 'extends BaseEnum',
	];
	
	public static function generate($config) {
		$config = ArrayHelper::merge($config, self::$defaultConfig);
		ClassGeneratorHelper::generate($config);
	}
	
}
