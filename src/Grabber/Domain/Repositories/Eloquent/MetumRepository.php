<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\MetumEntity;

class MetumRepository extends BaseEloquentCrudRepository
{

    public function tableName() : string
    {
        return 'grabber_meta';
    }

    public function getEntityClass() : string
    {
        return MetumEntity::class;
    }


}

