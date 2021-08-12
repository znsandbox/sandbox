<?php

namespace ZnSandbox\Sandbox\Application\Domain\Repositories\Eloquent;

use ZnLib\Db\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Application\Domain\Entities\ApplicationEntity;
use ZnSandbox\Sandbox\Application\Domain\Interfaces\Repositories\ApplicationRepositoryInterface;

class ApplicationRepository extends BaseEloquentCrudRepository implements ApplicationRepositoryInterface
{

    public function tableName() : string
    {
        return 'application_application';
    }

    public function getEntityClass() : string
    {
        return ApplicationEntity::class;
    }


}

