<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Person2\Domain\Entities\InheritanceEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\InheritanceRepositoryInterface;

class InheritanceRepository extends BaseEloquentCrudRepository implements InheritanceRepositoryInterface
{

    public function tableName() : string
    {
        return 'sandbox.person_inheritance';
    }

    public function getEntityClass() : string
    {
        return InheritanceEntity::class;
    }


}

