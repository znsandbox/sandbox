<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;

class ProfileRepository
{

    public static function findOneByName(string $projectName)
    {
//        $deployProfiles = ConfigProcessor::get('deployProfiles');
        $deployProfiles = self::findAll();
        $profileConfig = $deployProfiles[$projectName];
        return $profileConfig;
    }

    public static function findAll()
    {
        $deployProfiles = ConfigProcessor::get('deployProfiles');
        foreach ($deployProfiles as $projectName => $profileConfig) {
            $deployProfiles[$projectName] = self::prepareItem($profileConfig, $projectName);
        }
        return $deployProfiles;
    }
    
    protected static function prepareItem($profileConfig, $projectName) {
        $profileConfig['title'] = $profileConfig['title'] ?? $projectName;
        return $profileConfig;
    }
}
