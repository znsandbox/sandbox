<?php

namespace ZnSandbox\Sandbox\Settings\Domain\Repositories\Eloquent;

use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnCore\Domain\Query\Entities\Query;
use ZnCore\Domain\Repository\Mappers\JsonMapper;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\Settings\Domain\Entities\SystemEntity;
use ZnSandbox\Sandbox\Settings\Domain\Interfaces\Repositories\SystemRepositoryInterface;

class SystemRepository extends BaseEloquentCrudRepository implements SystemRepositoryInterface
{

    public function tableName(): string
    {
        return 'settings_system';
    }

    public function getEntityClass(): string
    {
        return SystemEntity::class;
    }

    public function mappers(): array
    {
        return [
            new JsonMapper(['value']),
        ];
    }

    public function allByName(string $name): Enumerable
    {
        $query = Query::forge();
        $query->where('name', $name);
        return $this->findAll($query);
    }
}
