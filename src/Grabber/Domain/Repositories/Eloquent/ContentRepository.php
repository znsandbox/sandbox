<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Repositories\Eloquent;

use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\ContentEntity;

class ContentRepository extends BaseEloquentCrudRepository
{

    public function tableName() : string
    {
        return 'grabber_content';
    }

    public function getEntityClass() : string
    {
        return ContentEntity::class;
    }


}

