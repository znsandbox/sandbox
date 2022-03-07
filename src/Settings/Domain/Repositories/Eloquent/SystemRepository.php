<?php

namespace ZnSandbox\Sandbox\Settings\Domain\Repositories\Eloquent;

use ZnSandbox\Sandbox\Settings\Domain\Entities\SystemEntity;
use ZnSandbox\Sandbox\Settings\Domain\Interfaces\Repositories\SystemRepositoryInterface;
use Illuminate\Support\Collection;
use ZnCore\Domain\Libs\Query;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnDatabase\Base\Domain\Mappers\JsonMapper;

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

    public function allByName(string $name): Collection
    {
        $query = Query::forge();
        $query->where('name', $name);
        return $this->all($query);
    }
}
