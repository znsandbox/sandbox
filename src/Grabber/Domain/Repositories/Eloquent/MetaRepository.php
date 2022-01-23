<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnLib\Db\Mappers\JsonMapper;
use ZnLib\Db\Mappers\TimeMapper;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\MetaEntity;

class MetaRepository extends BaseEloquentCrudRepository
{

    public function tableName() : string
    {
        return 'grabber_meta';
    }

    public function getEntityClass() : string
    {
        return MetaEntity::class;
    }

    public function mappers(): array
    {
        return [
            new JsonMapper(['attributes']),
            new TimeMapper(['created_at', 'updated_at']),
        ];
    }
}

