<?php

namespace ZnSandbox\Sandbox\Yii2\App;

class Constant
{

    public static function defineBase(string $rootDir) {
        self::defineBaseConst();
        self::defineNamesConst();
        self::defineDirsConst($rootDir);
    }

    public static function defineEnv(array $env)
    {
        defined('YII_DEBUG') or define('YII_DEBUG', $env['APP_DEBUG'] ?? false);
        defined('YII_ENV') or define('YII_ENV', $env['APP_ENV'] ?? 'dev');
    }

    public static function defineApp(string $appName)
    {
        defined('APP') or define('APP', $appName);
        //defined('APP_DIR') OR define('APP_DIR', self::path(strtolower($appName)));
    }

    private static function defineBaseConst()
    {
        defined('DS') OR define('DS', DIRECTORY_SEPARATOR);
        defined('SL') OR define('SL', '/');
        defined('BSL') OR define('BSL', '\\');
        defined('NBSP') OR define('NBSP', '&nbsp;');
        defined('NS') OR define('NS', "\n"); //new string Linux
        defined('BL') OR define('BL', '_'); //bottom line
        defined('DL') OR define('DL', '-'); //dash line
        defined('DOT') OR define('DOT', '.');
        defined('SPC') OR define('SPC', ' ');
        defined('EMP') OR define('EMP', '');
        defined('TAB') OR define('TAB', "\t");
        defined('BR') OR define('BR', '<br/>');
        defined('TIMESTAMP') OR define('TIMESTAMP', time());
    }

    private static function defineNamesConst() {
        defined('COMMON') OR define('COMMON', 'common');
        defined('FRONTEND') OR define('FRONTEND', 'frontend');
        defined('BACKEND') OR define('BACKEND', 'backend');
        defined('API') OR define('API', 'api');
        defined('CONSOLE') OR define('CONSOLE', 'console');
        defined('VENDOR') OR define('VENDOR', 'vendor');
    }

    private static function defineDirsConst(string $rootDir) {
        defined('ROOT_DIR') or define('ROOT_DIR', $rootDir);
        defined('COMMON_DIR') OR define('COMMON_DIR', $rootDir . DIRECTORY_SEPARATOR . COMMON);
        defined('COMMON_DATA_DIR') OR define('COMMON_DATA_DIR', COMMON_DIR . DS . 'data');
        //defined('FRONTEND_DIR') OR define('FRONTEND_DIR', $rootDir . DIRECTORY_SEPARATOR . FRONTEND);
        //defined('BACKEND_DIR') OR define('BACKEND_DIR', $rootDir . DIRECTORY_SEPARATOR . BACKEND);
        defined('API_DIR') OR define('API_DIR', $rootDir . DIRECTORY_SEPARATOR . API);
        //defined('CONSOLE_DIR') OR define('CONSOLE_DIR', $rootDir . DIRECTORY_SEPARATOR . CONSOLE);
        defined('VENDOR_DIR') OR define('VENDOR_DIR', $rootDir . DIRECTORY_SEPARATOR . VENDOR);
    }

}
