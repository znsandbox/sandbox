<?php

namespace ZnSandbox\Sandbox\RestClient\Domain\Repositories\Eloquent;

use ZnCore\Base\Domain\Libs\Query;
use ZnCore\Db\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\RestClient\Domain\Entities\ProjectEntity;
use ZnSandbox\Sandbox\RestClient\Domain\Interfaces\Repositories\ProjectRepositoryInterface;

class ProjectRepository extends BaseEloquentCrudRepository implements ProjectRepositoryInterface
{

    protected $tableName = 'restclient_project';

    public function getEntityClass(): string
    {
        return ProjectEntity::class;
    }

    public function oneByName(string $projectName): ProjectEntity
    {
        $query = new Query;
        $query->where('name', $projectName);
        return $this->one($query);
    }
}

