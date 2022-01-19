<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\SiteEntity;

class SiteRepository extends BaseEloquentCrudRepository
{

    public function tableName(): string
    {
        return 'grabber_site';
    }

    public function getEntityClass(): string
    {
        return SiteEntity::class;
    }
}