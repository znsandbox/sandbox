<?php

namespace ZnUser\Rbac\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnBundle\Person\Domain\Interfaces\Repositories\ContactTypeRepositoryInterface;
use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Relations\relations\OneToOneRelation;
use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnUser\Rbac\Domain\Entities\AssignmentEntity;
use ZnUser\Rbac\Domain\Interfaces\Repositories\AssignmentRepositoryInterface;
use ZnUser\Rbac\Domain\Interfaces\Repositories\ItemRepositoryInterface;

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
