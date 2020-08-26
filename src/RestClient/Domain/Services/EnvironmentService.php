<?php

namespace PhpLab\Sandbox\RestClient\Domain\Services;

use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Repositories\EnvironmentRepositoryInterface;
use PhpLab\Core\Domain\Base\BaseCrudService;
use PhpLab\Core\Domain\Libs\Query;

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
