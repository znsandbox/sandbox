<?php

use yii2tool\test\helpers\TestHelper;

$name = 'console';
$path = '../../../..';
defined('YII_ENV') OR define('YII_ENV', 'test');

@include_once(__DIR__ . '/' . $path . '/vendor/php7lab/yii2-legacy/src/yii2rails/app/App.php');

if(!class_exists(App::class)) {
	die('Run composer install');
}

App::init($name, __DIR__ . '/_application');

TestHelper::copySqlite(__DIR__);
