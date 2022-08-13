<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config;

use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\ConfigProcessor;

class ProfileRepository
{

    public static function findOneByName(string $projectName)
    {
        $deployProfiles = ConfigProcessor::get('deployProfiles');
        $profileConfig = $deployProfiles[$projectName];
        return $profileConfig;
    }

    public static function findAll()
    {
        $deployProfiles = ConfigProcessor::get('deployProfiles');
        return $deployProfiles;
    }
}
