<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;

class ProfileRepository
{

    public static function findOneByName(string $projectName)
    {
        $profiles = self::findAll();
        $profileConfig = $profiles[$projectName];
        return $profileConfig;
    }

    public static function findAll()
    {
        $profiles = ConfigProcessor::get('profiles');
        $new = [];
        foreach ($profiles as $profileName => $profileConfig) {
            if(!is_string($profileName)) {
                $hash = hash('sha256', $profileName);
//            $profileConfig = self::prepareItem($profileConfig, $hash);
                $profileName = $profileConfig['name'] ?? $hash;
            }
            $profileConfig['name'] = $profileName;
            $new[$profileName] = $profileConfig;
        }
        return $new;
    }
    
    /*protected static function prepareItem($profileConfig, $projectName) {
        $profileConfig['title'] = $profileConfig['title'] ?? $projectName;
        return $profileConfig;
    }*/
}
