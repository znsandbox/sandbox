<?php

namespace yii2rails\app\php;

class Autoload {

    const ROOT_DIR = __DIR__ . '/../../../../../';

    public static function init() {
        include(self::ROOT_DIR . '/vendor/autoload.php');
        spl_autoload_register([Autoload::class, 'autoloader']);
    }

    public static function autoloader($class) {
        $path = self::ROOT_DIR . sprintf('%s.php', $class);
        $path = realpath($path);
        if (file_exists($path)) {
            require($path);
        }
    }

}
