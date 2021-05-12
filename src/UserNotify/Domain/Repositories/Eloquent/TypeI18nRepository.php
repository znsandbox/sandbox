<?php

namespace ZnSandbox\Sandbox\UserNotify\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\UserNotify\Domain\Entities\TypeI18nEntity;
use ZnSandbox\Sandbox\UserNotify\Domain\Interfaces\Repositories\TypeI18nRepositoryInterface;
use ZnLib\Db\Base\BaseEloquentCrudRepository;

class TypeI18nRepository extends BaseEloquentCrudRepository implements TypeI18nRepositoryInterface
{

    public function tableName(): string
    {
        return 'notify_type_i18n';
    }

    public function getEntityClass(): string
    {
        return TypeI18nEntity::class;
    }


}

