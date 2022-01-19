<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnLib\Db\Mappers\JsonMapper;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\PageEntity;

class PageRepository extends BaseEloquentCrudRepository
{

    public function tableName(): string
    {
        return 'grabber_page';
    }

    public function getEntityClass(): string
    {
        return PageEntity::class;
    }

    public function mappers(): array
    {
        return [
            new JsonMapper(['query']),
        ];
    }
}