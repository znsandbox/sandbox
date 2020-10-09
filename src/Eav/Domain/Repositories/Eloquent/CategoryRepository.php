<?php

namespace ZnSandbox\Sandbox\Eav\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Eav\Domain\Entities\CategoryEntity;
use ZnSandbox\Sandbox\Eav\Domain\Interfaces\Repositories\CategoryRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class CategoryRepository extends BaseEloquentCrudRepository implements CategoryRepositoryInterface
{

    public function tableName(): string
    {
        return 'eav_category';
    }

    public function getEntityClass(): string
    {
        return CategoryEntity::class;
    }

}
