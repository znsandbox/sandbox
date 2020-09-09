<?php
defined('PHAR_LOADED') OR define('PHAR_LOADED', true);

spl_autoload_register(function ($class) {
    //$path = str_replace('\\', SL, $class);
    $aliases = [
        'yii2rails\\app' => 'src',
        'yii2rails\\app\\tests' => 'tests',
        'yii2rails\\app' => 'src',
        'yii2rails\\app\\tests' => 'tests',
    ];
    $fileName = null;
    foreach ($aliases as $name => $path) {
        if(strpos($class, $name) !== false) {
            $classPath = str_replace($name, '', $class);
            $classPath = str_replace('\\', '/', $classPath);
            $fileName = 'phar://yii2-app.phar/' . $path . $classPath . '.php';
        }
    }

    if(!$fileName) {
        return;
    }

    //exit($fileName);

    $result = include($fileName);
    return $result;
}, true, true);

__HALT_COMPILER();