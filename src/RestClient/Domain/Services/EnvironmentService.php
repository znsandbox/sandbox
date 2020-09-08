<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Services;

use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Repositories\EnvironmentRepositoryInterface;
use ZnCore\Base\Domain\Base\BaseCrudService;
use ZnCore\Base\Domain\Libs\Query;

class EnvironmentService extends BaseCrudService implements EnvironmentServiceInterface
{

    public function __construct(EnvironmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function allByProjectId(int $projectId, Query $query = null) {
        $query = Query::forge($query);
        $query->where('project_id', $projectId);
        return $this->all($query);
    }
}
