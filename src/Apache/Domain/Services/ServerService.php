<?php

namespace ZnSandbox\Sandbox\Apache\Domain\Services;

use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Traits\RepositoryAwareTrait;
use ZnSandbox\Sandbox\Apache\Domain\Entities\ServerEntity;
use ZnSandbox\Sandbox\Apache\Domain\Repositories\Conf\HostsRepository;
use ZnSandbox\Sandbox\Apache\Domain\Repositories\Conf\ServerRepository;

class ServerService
{

    use RepositoryAwareTrait;

    private $repository;
    private $hostsRepository;

    public function __construct(ServerRepository $repository, HostsRepository $hostsRepository)
    {
        $this->setRepository($repository);
        $this->hostsRepository = $hostsRepository;
    }

    public function all()
    {
        return $this->getRepository()->all2();
    }

    public function oneByName(string $name): ServerEntity
    {
        /** @var ServerEntity $serverEntity */
        $serverEntity = $this->getRepository()->oneByName($name);
        return $serverEntity;
    }
}
