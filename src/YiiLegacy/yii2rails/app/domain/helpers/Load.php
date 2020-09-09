<?php

namespace yii2rails\app\domain\helpers;

class Load
{

    const ROOT = __DIR__ . '/../../../../../..';
	const YII_CLASS = self::ROOT . DS . 'vendor' . DS . 'yiisoft' . DS . 'yii2' . DS . 'Yii.php';
	
	public static function autoload()
	{
		require(__DIR__ . '/../../../../../autoload.php');
	}
	
	public static function helpers()
	{

	}
	
	public static function yii($class)
	{
		if(empty($class)) {
			$class = self::YII_CLASS;
		}
		require($class);
	}
	
	public static function required()
	{
        require('Func.php');
	}

}
