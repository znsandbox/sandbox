<?php

namespace ZnSandbox\Sandbox\Person2\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Person2\Domain\Entities\PersonEntity;
use ZnSandbox\Sandbox\Person2\Domain\Interfaces\Repositories\PersonRepositoryInterface;

class PersonRepository extends BaseEloquentCrudRepository implements PersonRepositoryInterface
{

    public function tableName() : string
    {
        return 'person_person';
    }

    public function getEntityClass() : string
    {
        return PersonEntity::class;
    }
}
