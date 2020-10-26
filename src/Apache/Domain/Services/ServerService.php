<?php

namespace ZnSandbox\Sandbox\Apache\Domain\Services;

use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Apache\Domain\Entities\ServerEntity;
use ZnSandbox\Sandbox\Apache\Domain\Repositories\Conf\HostsRepository;
use ZnSandbox\Sandbox\Apache\Domain\Repositories\Conf\ServerRepository;

class ServerService
{

    private $repository;
    private $hostsRepository;

    public function __construct(ServerRepository $repository, HostsRepository $hostsRepository)
    {
        $this->repository = $repository;
        $this->hostsRepository = $hostsRepository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function oneByName(string $name): ServerEntity
    {
        /** @var ServerEntity $serverEntity */
        $serverEntity = $this->repository->oneByName($name);
        return $serverEntity;
    }
}
