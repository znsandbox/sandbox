<?php

namespace yii2rails\extension\registry\base;

use yii2rails\extension\registry\interfaces\RegistryInterface;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

abstract class BaseRegistry implements RegistryInterface {

    private static $classesData = [];

	static function get($key = null, $default = null) {
        $key = self::key($key);
		return ArrayHelper::getValue(self::$classesData, $key, $default);
	}
	
	static function has($key) {
		if(empty($key)) {
			return false;
		}
        $key = self::key($key);
		return ArrayHelper::has(self::$classesData, $key);
	}
	
	static function set($key, $value) {
        if(empty($key)) {
            return false;
        }
        $key = self::key($key);
        ArrayHelper::set(self::$classesData, $key, $value);
	}
	
	static function remove($key) {
        if(empty($key)) {
            return false;
        }
		if(self::has($key)) {
			ArrayHelper::remove(self::$classesData[static::class], $key);
		}
	}

    static function reset() {
        self::$classesData[static::class] = [];
    }

    static function load($data) {
        self::$classesData[static::class] = $data;
    }

    static function merge($data) {
        self::$classesData[static::class] = ArrayHelper::merge(self::$classesData[static::class], $data);
    }
	
	private static function key($key = null) {
		$result = static::class;
		if($key) {
			$result .= DOT . $key;
		}
		return $result;
	}
	
	protected function __construct() {}
	
}
