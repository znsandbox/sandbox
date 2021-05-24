<?php

namespace ZnSandbox\Sandbox\Casbin\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnBundle\Person\Domain\Interfaces\Repositories\ContactTypeRepositoryInterface;
use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Casbin\Domain\Entities\AssignmentEntity;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\AssignmentRepositoryInterface;
use ZnSandbox\Sandbox\Casbin\Domain\Interfaces\Repositories\ItemRepositoryInterface;

class AssignmentRepository extends BaseEloquentCrudRepository implements AssignmentRepositoryInterface
{

    public function tableName(): string
    {
        return 'rbac_assignment';
    }

    public function getEntityClass(): string
    {
        return AssignmentEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'item_name',
                'relationEntityAttribute' => 'item',
                'foreignAttribute' => 'name',
                'foreignRepositoryClass' => ItemRepositoryInterface::class,
            ],
        ];
    }

    public function allByIdentityId(int $identityId, Query $query = null): Collection
    {
        $query = Query::forge($query);
        $query->where('identity_id', $identityId);
        return $this->all($query);
    }
}
