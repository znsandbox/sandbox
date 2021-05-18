<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnCore\Domain\Libs\Query;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\AssignmentEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\AssignmentRepositoryInterface;

class AssignmentRepository extends BaseEloquentCrudRepository implements AssignmentRepositoryInterface
{

    public function tableName() : string
    {
        return 'rbac_assignment';
    }

    public function getEntityClass() : string
    {
        return AssignmentEntity::class;
    }

    public function allByIdentityId(int $identityId): Collection {
        $query = new Query();
        $query->where('identity_id', $identityId);
        return $this->all($query);
    }
}

