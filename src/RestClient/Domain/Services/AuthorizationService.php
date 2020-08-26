<?php

namespace PhpLab\Sandbox\RestClient\Domain\Services;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Base\BaseCrudService;
use PhpLab\Sandbox\RestClient\Domain\Entities\AuthorizationEntity;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Repositories\AuthorizationRepositoryInterface;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Services\AuthorizationServiceInterface;

class AuthorizationService extends BaseCrudService implements AuthorizationServiceInterface
{

    public function __construct(AuthorizationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function allByProjectId(int $projectId, string $type = null): Collection
    {
        return $this->getRepository()->allByProjectId($projectId, $type);
    }

    public function oneByUsername(int $projectId, string $username, string $type = null): AuthorizationEntity
    {
        return $this->getRepository()->oneByUsername($projectId, $username, $type);
    }

}
