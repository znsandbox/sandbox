<?php

namespace yii2rails\domain\values;

use yii\base\InvalidConfigException;
use yii2rails\extension\common\helpers\ReflectionHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

abstract class BaseEnumValue extends BaseValue {
	
	public function isValid($value) {
		$range = $this->getRangeArray();
		return in_array($value, $range);
	}
	
	protected function getRangeArray() {
		$constants = ReflectionHelper::getConstants(static::class);
		if(empty($constants)) {
			throw new InvalidConfigException('Not found constants in "EnumValue"');
		}
		$range = array_values($constants);
		return $range;
	}
	
	public function getDefault() {
		$range = $this->getRangeArray();
		return ArrayHelper::first($range);
	}
}
