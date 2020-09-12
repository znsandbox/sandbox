<?php

namespace ZnSandbox\Sandbox\Yii2\App\Loader;

class BasicLoader extends BaseLoader
{

    public function bootstrapApp(string $appName)
    {
        include __DIR__ . '/../../../../../../../config/bootstrap.php';
    }

    public function mainConfigFiles(string $appName): array
    {
        if($this->isTestEnv()) {
            $configFiles = [
                "config/$appName.php",
                "config/test.php",
            ];
        } else {
            $configFiles = [
                "config/$appName.php",
            ];
        }
        return $configFiles;
    }

    public function paramConfigFiles(string $appName): array
    {
        return [
            "config/params.php",
            "config/params-local.php",
        ];
    }
}
