<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Text\Helpers\TemplateHelper;

class ConfigProcessor
{

    private static $config;

    /*public static function set(string $key, $value): void
    {
        ArrayHelper::set(self::$config, $key, $value);
    }*/

    public static function get(string $key, $default = null)
    {
        self::init();
        return ArrayHelper::getValue(self::$config, $key, $default);
    }

    private static function init()
    {
        if (self::$config) {
            return;
        }
        self::$config = include($_ENV['DEPLOYER_CONFIG_FILE']);
    }
}
