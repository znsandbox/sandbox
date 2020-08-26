<?php

namespace PhpLab\Sandbox\RestClient\Domain\Services;

use PhpLab\Sandbox\RestClient\Domain\Interfaces\Repositories\AccessRepositoryInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\AccessServiceInterface;
use PhpLab\Core\Domain\Base\BaseCrudService;

class AccessService extends BaseCrudService implements AccessServiceInterface
{

    public function __construct(AccessRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function attach($projectId, $userId) {
        $this->create([
            'projectId' => $projectId,
            'userId' => $userId,
        ]);
    }

    public function detach($projectId, $userId) {
        $this->repository->deleteByCondition([
            'project_id' => $projectId,
            'user_id' => $userId,
        ]);
    }
}
