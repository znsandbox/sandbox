<?php

$name = 'console';
$path = '../../../../../..';

@include_once(__DIR__ . '/' . $path . '/vendor/znsandbox/sandbox/src/YiiLegacy/yii2rails/app/App.php');

if(!class_exists(App::class)) {
    die('Run composer install');
}

App::initPhpApplication($name);
