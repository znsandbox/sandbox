<?php

namespace ZnSandbox\Sandbox\Yii2\App\Loader;

class AdvancedLoader extends BaseLoader
{

    public function bootstrapApp(string $appName)
    {
        include __DIR__ . '/../../../../../../../common/config/bootstrap.php';
        include __DIR__ . '/../../../../../../../' . $appName . '/config/bootstrap.php';
    }

    public function mainConfigFiles(string $appName): array
    {
        if($this->isTestEnv()) {
            $configFiles = [
                "common/config/main.php",
                "common/config/main-local.php",
                "common/config/test.php",
                "common/config/test-local.php",
                "$appName/config/main.php",
                "$appName/config/main-local.php",
                "$appName/config/test.php",
                "$appName/config/test-local.php",
            ];
        } else {
            $configFiles = [
                "common/config/main.php",
                "common/config/main-local.php",
                "$appName/config/main.php",
                "$appName/config/main-local.php",
            ];
        }
        return $configFiles;
    }

    public function paramConfigFiles(string $appName): array
    {
        return [
            "common/config/params.php",
            "common/config/params-local.php",
            "$appName/config/params.php",
            "$appName/config/params-local.php",
        ];
    }

}
