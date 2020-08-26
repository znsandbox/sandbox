<?php

namespace PhpLab\Sandbox\RestClient\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Eloquent\Db\Base\BaseEloquentCrudRepository;
use PhpLab\Sandbox\RestClient\Domain\Entities\AuthorizationEntity;
use PhpLab\Sandbox\RestClient\Domain\Interfaces\Repositories\AuthorizationRepositoryInterface;

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
