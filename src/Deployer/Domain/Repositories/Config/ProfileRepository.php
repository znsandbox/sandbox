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
        $new = [];
        foreach ($deployProfiles as $projectName => $profileConfig) {
            $hash = hash('sha256', $projectName);
//            $profileConfig = self::prepareItem($profileConfig, $hash);
            $new[$hash] = $profileConfig;
        }
        return $new;
    }
    
    /*protected static function prepareItem($profileConfig, $projectName) {
        $profileConfig['title'] = $profileConfig['title'] ?? $projectName;
        return $profileConfig;
    }*/
}
