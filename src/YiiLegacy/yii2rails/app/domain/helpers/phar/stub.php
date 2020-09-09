<?php
defined('PHAR_LOADED') OR define('PHAR_LOADED', true);

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class);
    /*if($path == 'Yii') {
        $path = 'yii/Yii';
    }*/
    $fileName = 'phar://../../' . PHAR_FILE . '/' . $path . '.php';
    $result = @include($fileName);
    /*if(!class_exists($class)) {
        \yii2rails\app\domain\helpers\phar\PharCacheHelper::addClass($class);
    }*/
    return $result;
});

__HALT_COMPILER();