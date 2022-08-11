<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Libs;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Text\Helpers\TemplateHelper;

class VarProcessor
{

    private static $vars;

    public static function process(string $value): string
    {
        self::init();
        return self::render($value, self::$vars);
    }

    public static function set(string $key, $value): void
    {
        self::init();
        ArrayHelper::set(self::$vars, $key, $value);
        self::initVars();
    }

    public static function get(string $key, $default = null)
    {
        return ArrayHelper::getValue(self::$vars, $key, $default);
    }

    private static function render($value, $vars)
    {
        return TemplateHelper::render($value, $vars, '{{', '}}');
    }

    private static function init()
    {
        if (self::$vars) {
            return;
        }

        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
        self::$vars = $config['vars'];

        self::initVars();
    }

    public static function initVars()
    {
        self::$vars = self::processVars(self::$vars);
    }

    private static function processVars($vars)
    {
        do {
            $oldVars = $vars;
            foreach ($vars as $index => $var) {
                $vars[$index] = self::render($var, $vars);
            }
        } while ($oldVars !== $vars);
        return $vars;
    }
}
