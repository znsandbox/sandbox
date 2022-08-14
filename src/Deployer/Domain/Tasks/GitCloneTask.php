<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks;

use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\GitShell;
use ZnSandbox\Sandbox\Deployer\Domain\Services\Shell\BaseShell;

class GitCloneTask extends BaseShell implements TaskInterface
{

    public $repository;
    public $branch;

    public function run(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);

        $this->io->writeln('git clone ... ');
        $this->clone($profileName);
    }

    protected function clone(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $git = new GitShell($this->remoteShell);
        $git->setDirectory(VarProcessor::get('release_path'));

        $fs = new FileSystemShell($this->remoteShell);
        $fs->makeDirectory(VarProcessor::get('release_path'));
        if (!$fs->isDirectoryExists(VarProcessor::get('release_path') . '/.git')) {
            $git->clone($this->repository, $this->branch ?? null, VarProcessor::get('release_path'));
        } else {
            $this->io->warning('repository already exists!');

            $this->io->writeln("checkout to '{$this->branch}' branch ...");
            $git->checkout($this->branch);

            $this->io->writeln('git pull ...');
            $git->pull();
        }
    }
}
