<?php

namespace ZnSandbox\Sandbox\App\Loader;

class BasicLoader extends BaseLoader
{

    public function bootstrapApp(string $appName)
    {
        //include __DIR__ . '/config/bootstrap.php';
    }

    public function mainConfigFiles(string $appName): array
    {
        $isTestEnv = $this->env['APP_ENV'] == 'test';
        if($isTestEnv) {
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
