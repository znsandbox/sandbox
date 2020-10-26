<?php

namespace ZnSandbox\Sandbox\Apache\Domain\Services;

use ZnSandbox\Sandbox\Apache\Domain\Repositories\Conf\ServerRepository;

class ServerService
{

    private $repository;

    public function __construct(ServerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all() {
        return $this->repository->all();
    }
}
