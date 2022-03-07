<?php

namespace ZnSandbox\Sandbox\Organization\Domain\Repositories\Eloquent;

use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Organization\Domain\Entities\TypeEntity;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Repositories\TypeRepositoryInterface;

class TypeRepository extends BaseEloquentCrudRepository implements TypeRepositoryInterface
{

    public function tableName() : string
    {
        return 'organization_type';
    }

    public function getEntityClass() : string
    {
        return TypeEntity::class;
    }


}

