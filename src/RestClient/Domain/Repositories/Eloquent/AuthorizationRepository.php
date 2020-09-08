<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnCore\Base\Domain\Libs\Query;
use ZnCore\Db\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\RestClient\Domain\Entities\AuthorizationEntity;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Repositories\AuthorizationRepositoryInterface;

class AuthorizationRepository extends BaseEloquentCrudRepository implements AuthorizationRepositoryInterface
{

    protected $tableName = 'restclient_authorization';

    public function getEntityClass(): string
    {
        return AuthorizationEntity::class;
    }

    public function allByProjectId(int $projectId, string $type = null): Collection
    {
        $query = new Query;
        $query->where('project_id', $projectId);
        if ($type) {
            $query->where('type', 'bearer');
        }
        return $this->all($query);
    }

    public function oneByUsername(int $projectId, string $username, string $type = null): AuthorizationEntity
    {
        $query = new Query;
        $query->where('project_id', $projectId);
        $query->where('type', 'bearer');
        $query->where('username', $username);
        return $this->one($query);
    }

}
