<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Git;

use ZnSandbox\Sandbox\Deployer\Domain\Base\BaseShell;
use ZnSandbox\Sandbox\Deployer\Domain\Interfaces\TaskInterface;
use ZnSandbox\Sandbox\Deployer\Domain\Libs\App\VarProcessor;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\FileSystemShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\GitShell;

class GitCloneTask extends BaseShell implements TaskInterface
{

    protected $title = 'git clone from "{{repositoryLink}}", branch "{{branch}}"';
    public $directory;
    public $repositoryLink;
    public $branch;

    public function run()
    {
        $releasePath = VarProcessor::process($this->directory);

        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $git = new GitShell($this->remoteShell);
        $git->setDirectory($releasePath);

        $fs = new FileSystemShell($this->remoteShell);
        $fs->makeDirectory($releasePath);
        if (!$fs->isDirectoryExists($releasePath . '/.git')) {
            $git->clone($this->repositoryLink, $this->branch ?? null, $releasePath);
        } else {
            $this->io->warning('  repository already exists!');

            $this->io->writeln("  checkout to '{$this->branch}' branch ...");
            $git->checkout($this->branch);

            $this->io->writeln('  git pull ...');
            $git->pull();
        }
    }
}
