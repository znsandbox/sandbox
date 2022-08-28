<?php

namespace ZnSandbox\Sandbox\Deployer\Domain\Tasks\Deploy;

use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;
use ZnLib\Components\ShellRobot\Domain\Repositories\Config\ProfileRepository;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\ApacheShell;
use ZnSandbox\Sandbox\Deployer\Domain\Repositories\Shell\HostsShell;
use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;

class ConfigureDomainTask extends BaseShell implements TaskInterface
{

    protected $title = 'Configure host';
    public $domains;

    public function run()
    {
        $profileName = VarProcessor::get('currentProfile');
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $this->assignDomains($profileName);
    }

    protected function assignDomains(string $profileName)
    {
        $profileConfig = ProfileRepository::findOneByName($profileName);
        $apache = new ApacheShell($this->remoteShell);
        $hosts = new HostsShell($this->remoteShell);

        foreach ($this->domains as $item) {
            $domain = VarProcessor::process($item['domain']);
            $directory = VarProcessor::process($item['directory']);
            $hosts->add($domain);
            $apache->addConf($domain, $directory);
            $this->io->writeln("http://{$domain}:8080/");
        }
    }
}
