<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;

class ProfileRepository
{

    public static function findOneByName(string $projectName)
    {
//        $deployProfiles = ConfigProcessor::get('deployProfiles');
        $deployProfiles = self::findAll();
//        dd($deployProfiles);
        $profileConfig = $deployProfiles[$projectName];
        return $profileConfig;
    }

    public static function findAll()
    {
        $deployProfiles = ConfigProcessor::get('deployProfiles');
        $new = [];
        foreach ($deployProfiles as $projectName => $profileConfig) {
            if(is_string($projectName)) {

            } else {
                $hash = hash('sha256', $projectName);
//            $profileConfig = self::prepareItem($profileConfig, $hash);

                $projectName = $profileConfig['name'] ?? $hash;
            }


            $profileConfig['name'] = $projectName;

            $new[$projectName] = $profileConfig;
        }
        return $new;
    }
    
    /*protected static function prepareItem($profileConfig, $projectName) {
        $profileConfig['title'] = $profileConfig['title'] ?? $projectName;
        return $profileConfig;
    }*/
}
