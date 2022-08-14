<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class InitReleaseTask extends BaseShell implements TaskInterface
{

    public $historySize;
    public $branch;

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $releasePath = VarProcessor::get('release_path');
        $releasesDir = $releasePath . '/release';
        
        $version = 1;

        $fs = new FileSystemShell($this->remoteShell);

        if($fs->isDirectoryExists($releasesDir)) {
            $versionList = $fs->list($releasesDir);
            $versionList = ArrayHelper::getColumn($versionList, 'fileName');
            $versionList = array_map(function ($value) {
                return intval($value);
            }, $versionList);
            sort($versionList);
            $lastVersion = ArrayHelper::last($versionList);
            $version = $lastVersion + 1;

//            dd($version);
        }

        $this->io->writeln("  Current build version {$version}");
        $fs->makeDirectory($releasesDir . '/' . $version);
        VarProcessor::set('release_path', $releasesDir . '/' . $version);

//        dd($version);
        
        

//        dd(VarProcessor::get('release_path'));
        
        $this->io->writeln('init release ... ');
        
    }
}
